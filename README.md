# pro·em

> –noun
> an introductory discourse; introduction; preface; preamble.

> Origin:
> 1350–1400; < L prooemium < Gk prooímion prelude (pro- pro-2 + oím(ē) song + -ion dim. suffix);
> r. ME proheme < MF < L, as above

## DESCRIPTION

A small, simple, PHP MVC.

The main objective here is to create a small, simple, fast PHP MVC framework. I am convinced
with the idea of designing an application object around the idea of the filter chain pattern.

A request comes in which initiates the chain, filters the request data while building all of
the resources required to respond. The response is then filtered and built back out through
the chain and off to the client. Simple, in theory.

## INSTALLATION

Installation is simple. Place the root Proem directory wherever you like and insure that the
lib directory is on php's include_path. That's it !

## CONTRIBUTING

#### Filing Bugs and Building Test Cases

This is the best way to contribute to Proem. Visit our [bugtracker](http://github.com/trq/proem/tickets).

#### Committing and Pull Requests

If you wish to contribute code to Proem please make sure you've first filed a bug report detailing your specific bug or feature request.

Next, [create an account on Github](https://github.com/signup/free) (if you haven't done so already).

Create a fork of the [Proem Github project](http://github.com/trq/proem) ([More details on forking](http://help.github.com/forking/)).

Before you write any code be sure to create a new branch in your repository in which all the changes will be committed. More details about Git branches can be found in the [Pro Git chapter on branches](http://progit.org/book/ch3-1.html) and in the chapter on [remote branches](http://progit.org/book/ch3-5.html).

After your new branch has been pushed to your repository you can now send a [pull request](http://help.github.com/pull-requests/). Be sure to reference the bug(s) that you're fixing in the commit messages and in the pull request description (this helps us to track the changes easier).

## DISCUSSION

#### IRC

The proem project has an irc channel available [#proem](http://webchat.freenode.net/?channels=proem) on irc.freeonde.net
