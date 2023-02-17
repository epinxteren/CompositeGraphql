GraphQL's library used for extending the graphql tree with custom fields and types with ease.

The library itself is a object builder during compilation time, 
which means that it's not a runtime library, but a compile time library.

## Installation

### Goals

Some of the goals of this library are:

1. Performance is important
2. Easy to use
3. Easy to extend
4. Easy to integrate with other libraries

## Problems it solves

### Shared kernel in presentation layer

We want to a single GraphQL schema for our clients, but we have multiple presentation layers,
that are not aware of each other. We want to share the same GraphQL schema between all of them.

This can extend the GraphQL schema from other modules, and it can be used in multiple presentation layers.

### Api platform

Api platform is a great library, but it's not a GraphQL library. It's a REST library, that can be used to generate a GraphQL schema.
The performance of the library is not great, and it's not easy to extend the schema with custom fields.

## Implementation

### GraphQL


### Docker

The docker image is used for development purposes, and it's not meant to be used in production. The image is 
based on the official PHP image, but the dockerfile is copied from different php project and has unnecessary
stuff in it.
