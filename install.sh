#!/usr/bin/env bash

if [ ! -f .config ]; then
    cp .config.dist .config
fi