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

## Contributing

# Filing Bugs and Building Test Cases

This is the best way to contribute to Proem. Visit http://github.com/trq/proem/tickets.

# Committing and Pull Requests

If you wish to contribute code to Proem please make sure you've first filed a bug report detailing your specific bug or feature request.

Next, [https://github.com/signup/free](create an account on Github) (if you haven't done so already).

Create a fork of the [http://github.com/trq/proem](Proem Github project) ([http://help.github.com/forking/](More details of forking)).

Before you write any code be sure to create a new branch in your repository in which all the changes will be committed. More details about Git branches can be found in the [http://progit.org/book/ch3-1.html](Pro Git chapter on branches) and in the chapter on [http://progit.org/book/ch3-5.html](remote branches).

After your new branch has been pushed to your repository you can now send a [http://help.github.com/pull-requests/](pull request). Be sure to reference the bug(s) that you're fixing in the commit messages and in the pull request description (this helps us to track the changes easier).

## Discussion

# IRC

The proem project has an irc channel available [http://webchat.freenode.net/?channels=jquery-dev](#proem) on irc.freeonde.net
