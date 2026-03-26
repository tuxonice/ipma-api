#!/bin/bash
set -e

USER_ID="${UID:-1000}"
GROUP_ID="${GID:-1000}"

if ! getent group "$GROUP_ID" > /dev/null 2>&1; then
    groupadd -g "$GROUP_ID" appgroup
fi

if ! getent passwd "$USER_ID" > /dev/null 2>&1; then
    useradd -u "$USER_ID" -g "$GROUP_ID" -d /tmp -s /bin/bash appuser
fi

exec gosu "$USER_ID" "$@"
