Atanor Di - Graph based dependency injector

About dependency in OOP
Any object in OOP may  use another one for any task. Having perfectly decoupled object is impossible and you have to deal
with it in your applications every day. The main issue with dependency is to manage the risk of seeing an object stopping 
running as expected when one of its dependency class has been changed.
There is a rule that prevent dependency management to become a nightmare called Dependency Inversion.
Abstraction like interfaces and abstract class are more stable than concrete classes. For this reason it is always
best to create dependency to abstraction instead of concrete class.
That lead us to another problem, if a class has a dependency to abstraction, it becomes enable to build its own dependencies.
To deal with this, we have to use Dependency Injection which is a process that inject expected concrete dependency into an object.
Dependency injection is managed mostly by constructor or "setters" :

Dependency Graph
Many objects of your application may have several dependencies to objects an those objects also have dependencies. 
Most objects of your application, mainly "services" are shared between a lot of other instances through dependency.
At the end it create a dependency graph in which every instance is a node that is linked to others nodes.
It means that building a giving object of this graph imply starting by building its dependent objects, and then inject 
them into the first object. Obviously those dependency may need some other object to be instantiated first. You see the problem.
To deal with that sort of complexity, we make use of Injection container that are able to ease the process for you.

Injection containers
Injection containers mainly use 

The Atanor point of view.
Atanor\Di is a dependency injection componenet base on Dependency graphs.
Be cause at the end of the day, object will creat a graph, we decide to strat from this graph to describe how object will be
connected to each other when instantiated.

The Ghos