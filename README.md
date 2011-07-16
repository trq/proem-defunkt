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

#### The Twitter Feed
Proem now has a dedicated twitter feed http://twitter.com/proem which will automatically post any commits as well as news. If you plan on helping out, you should follow this feed.

#### The Issue Tracker
There are currently 4 types of labels in the bugtracker and they work like this:

proposal: A feature request or idea for new feature implimentation. (These are not to be assigned to any milestone)
candy: A feature, Idea or Proposal which has been determined to be unimportant/not required. Icing on the cake. Being marked as candy means the idea is on the backburner (but not forgotten). (These are not to be assigned to any milestone)
task: A feature, Idea or Proposal which has been accepted and is to be worked on. (These will have a milestone assigned to them).
bug: A bug within current code. These take priority over any other work and where possible should be assigned to the next available milestone.

A new feature or idea should be marked as a 'proposal' and should not be assigned to any milestone. While an issue is a proposal the idea can be fleshed out and commented on until a concrete idea of how it will be implimented is formed. Once that is done and the idea is determined to be viable, the issue will likely be moved to a 'task', or if need be a 'bug' and it will be allocated a milestone.
Tasks are components of work that are ready to be implimented. If you plan on working on a Task please attempt to assign it to yourself before doing so. No one want's to double up on what is being done.
Bugs work the same as Tasks but take high priority.

#### Filing Bugs and Building Test Cases

This is the best way to contribute to Proem. Visit our [Issue Tracker](http://github.com/trq/proem/issues).

#### Committing and Pull Requests

If you wish to contribute code to Proem please make sure you use the [Issue Tracker](http://github.com/trq/proem/issues).

Next, [create an account on Github](https://github.com/signup/free) (if you haven't done so already).

Create a fork of the [Proem Github project](http://github.com/trq/proem) ([More details on forking](http://help.github.com/forking/)).

Before you write any code be sure to create a new branch in your repository in which all the changes will be committed. More details about Git branches can be found in the [Pro Git chapter on branches](http://progit.org/book/ch3-1.html) and in the chapter on [remote branches](http://progit.org/book/ch3-5.html).

After your new branch has been pushed to your repository you can now send a [pull request](http://help.github.com/pull-requests/). Be sure to reference the bug(s) that you're fixing in the commit messages and in the pull request description (this helps us to track the changes easier).

We (I) follow the git flow branching model as described by nvie [here](http://nvie.com/posts/a-successful-git-branching-model) using his awesome tool [git-flow](https://github.com/nvie/gitflow) hosted right here on github.
