# Makefile for IPAM API

# Colors for output
BLUE := \033[0;34m
GREEN := \033[0;32m
YELLOW := \033[1;33m
RED := \033[0;31m
NC := \033[0m

# Default target
.PHONY: help
help:
	@echo "$(BLUE)IPMA API - Makefile Commands$(NC)"
	@echo "========================================"
	@echo ""
	@echo "$(YELLOW)Usage:$(NC)"
	@echo "  make [command]"
	@echo ""
	@echo "$(YELLOW)Available commands:$(NC)"
	@echo "  $(GREEN)help$(NC)       - Display this help message"
	@echo "  $(GREEN)test$(NC)       - Run all tests"
	@echo "  $(GREEN)test-unit$(NC)  - Run unit tests only"
	@echo "  $(GREEN)coverage$(NC)   - Generate test coverage report"
	@echo "  $(GREEN)shell$(NC)      - Open interactive shell in container"
	@echo "  $(GREEN)phpcs$(NC)      - Run PHP CodeSniffer"
	@echo "  $(GREEN)phpcs-fix$(NC)  - Fix PHP CodeSniffer errors automatically"
	@echo "  $(GREEN)phpstan$(NC)    - Run PHPStan static analysis"
	@echo "  $(GREEN)install$(NC)    - Install dependencies"
	@echo "  $(GREEN)rebuild$(NC)    - Rebuild Docker image"
	@echo "  $(GREEN)clean$(NC)      - Clean up Docker containers and volumes"

# Check if Docker is running
.PHONY: check-docker
check-docker:
	@if ! docker info > /dev/null 2>&1; then \
		echo "$(RED)[ERROR]$(NC) Docker is not running. Please start Docker first."; \
		exit 1; \
	fi

UID := $(shell id -u)
GID := $(shell id -g)

# Install dependencies
.PHONY: install
install: check-docker
	@echo "$(BLUE)[INFO]$(NC) Installing PHP dependencies..."
	@UID=$(UID) GID=$(GID) docker-compose run --rm php-test composer install

# Run all tests
.PHONY: test
test: check-docker install
	@echo "$(BLUE)[INFO]$(NC) Running all tests..."
	@UID=$(UID) GID=$(GID) docker-compose run --rm test-runner

# Run unit tests only
.PHONY: test-unit
test-unit: check-docker install
	@echo "$(BLUE)[INFO]$(NC) Running unit tests..."
	@UID=$(UID) GID=$(GID) docker-compose run --rm test-runner ./vendor/bin/phpunit tests/Unit/

# Generate test coverage report
.PHONY: coverage
coverage: check-docker install
	@echo "$(BLUE)[INFO]$(NC) Generating test coverage report..."
	@UID=$(UID) GID=$(GID) docker-compose run --rm test-runner ./vendor/bin/phpunit --coverage-html=coverage
	@echo "$(GREEN)[SUCCESS]$(NC) Coverage report generated in coverage/ directory"

# Open interactive shell in container
.PHONY: shell
shell: check-docker
	@echo "$(BLUE)[INFO]$(NC) Opening interactive shell in test container..."
	@UID=$(UID) GID=$(GID) docker-compose run --rm php-test bash

# Run PHP CodeSniffer
.PHONY: phpcs
phpcs: check-docker install
	@echo "$(BLUE)[INFO]$(NC) Running PHP CodeSniffer..."
	@UID=$(UID) GID=$(GID) docker-compose run --rm php-test ./vendor/bin/phpcs --standard=phpcs.xml

# Fix PHP CodeSniffer errors automatically
.PHONY: phpcs-fix
phpcs-fix: check-docker install
	@echo "$(BLUE)[INFO]$(NC) Fixing PHP CodeSniffer errors..."
	@UID=$(UID) GID=$(GID) docker-compose run --rm php-test ./vendor/bin/phpcbf --standard=phpcs.xml

# Run PHPStan static analysis
.PHONY: phpstan
phpstan: check-docker install
	@echo "$(BLUE)[INFO]$(NC) Running PHPStan static analysis..."
	@UID=$(UID) GID=$(GID) docker-compose run --rm php-test ./vendor/bin/phpstan analyse -c phpstan.neon

# Rebuild Docker image
.PHONY: rebuild
rebuild: check-docker
	@echo "$(BLUE)[INFO]$(NC) Rebuilding Docker image..."
	@UID=$(UID) GID=$(GID) docker-compose build --no-cache
	@echo "$(GREEN)[SUCCESS]$(NC) Image rebuilt successfully"

# Clean up Docker containers and volumes
.PHONY: clean
clean: check-docker
	@echo "$(BLUE)[INFO]$(NC) Cleaning up Docker containers and volumes..."
	@docker-compose down -v --rmi local
	@echo "$(GREEN)[SUCCESS]$(NC) Cleanup completed"
