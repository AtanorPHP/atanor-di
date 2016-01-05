Dependency Injection graph (DiGraph)
-----
A DiGraph is a representation of the link that exists between some instances.Relationship between all services 
of an application can be describe as DiGraph.
DiGraph purpose is not to hold instances but registering data needed to build any instance.

Ghosts
------
A ghost is a virtual representation of an object instance within a Dependency Injection Graph (DiGraph).

Wizard
------
Wizard is an object able to build an instance from its ghost (invocation). To do that a Wizard will make use of a Constructor 
and an injector.

Dependency Injection containers
------
A container is a mix of a Wizard and a DiGraph. It can invoke (build) any instance Ghost contained into the DiGraph.

Injectors
------
It is an object responsible of injection of already instantiated objects into a target object.
It use Injection Strategies to do that.
Each InjectionStrategy is a way to inject dependency into an object:

- Setter injection using setters
- Reflection injection using reflection
- Injection interface injection
etc.
Injected dependnecy are represneted has "Dependency" objet which is an object containing data to inject and data 
used to manage injection : property name by example.

Constructors
------
Constructor is an object made to build an object of a given class using its constructor. Constructors will be feed
with class name and constructor parameters.
There is many type of constructor dependnding on the algorithm they use to deal with instance building:
"new" statement
Reflection
a stack of other constructor.


