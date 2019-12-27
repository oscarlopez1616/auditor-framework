#!/usr/bin/env bash

set -ex

su -s /bin/bash -c 'ansible-playbook playbook-setup-web-container.yml'
su -s /bin/bash -c './gradlew'

exec php-fpm

