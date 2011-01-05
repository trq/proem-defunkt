pro·em
====================================

> –noun
> an introductory discourse; introduction; preface; preamble.


> Origin:
> 1350–1400; < L prooemium < Gk prooímion prelude (pro- pro-2 + oím(ē) song + -ion dim. suffix);
> r. ME proheme < MF < L, as above

====================================

## DESCRIPTION

A small, simple, PHP MVC.

The main objective here is to create a small, simple, fast PHP MVC framework. I am convinced
with the idea of designing an application object around the idea of the filter chain pattern.

A request comes in which initiates the chain, filters the request data while building all of
the resources required to respond. The response is then filtered and built back out through
the chain and off to the client. Simple, in theory.

====================================

## INSTALLATION

Installation is simple. Place the root Proem directory wherever you like and insure that the
lib directory is on php's include_path. That's it!

## DEVELOPMENT

If you want to fork Proem go ahead. I would appreciate requests but will only pull code that
has sufficient & passing unit tests.

All Unit tests should be executed from within the root Proem directory using:

./bin/runtests