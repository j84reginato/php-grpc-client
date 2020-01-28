#!/bin/bash

protoc --proto_path=./protofile \
       --php_out=./src \
       --grpc_out=./src \
       --plugin=protoc-gen-grpc=./../grpc/bins/opt/grpc_php_plugin \
       ./protofile/protofile.proto

