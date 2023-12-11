#!/bin/bash

# Nombre del usuario y grupo a crear (pasados como argumentos)
USER_NAME=$1
GROUP_NAME=${2:-docker}

# Crea el grupo si no existe
if ! getent group "$GROUP_NAME" > /dev/null 2>&1; then
  groupadd "$GROUP_NAME"
fi

# Crea el usuario y añádelo al grupo
useradd -s /bin/bash -m -g "$GROUP_NAME" "$USER_NAME"

# Añade el usuario al grupo (por ejemplo, al grupo docker)
usermod -aG "$GROUP_NAME" "$USER_NAME"
