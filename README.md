# Read Counter Module

Package to provide a very simple mechanism to count page impressions and save them in a page property.

## Installation

After downloading check in the neos backend if this package is enabled as application or plugin.

In your main `Configuration/Routes.yaml` add the following snippet to activate te package:

```
-
  name: 'Futjikato.ReadCounter'
  uriPattern: '<ReadCounterSubroutes>'
  subRoutes:
    'ReadCounterSubroutes':
      package: 'Futjikato.ReadCounter'
```

The route to call via ajax ist `/readcounter/tracking?node=<nodePath>`.

Every page that should be countable must be extended by the `Futjikato.ReadCounter:CounterMixin` mixin:

```
'Futjikato.DemoSite:CountedPage':
  superTypes:
    'TYPO3.Neos.NodeTypes:Page': true
    'Futjikato.ReadCounter:CounterMixin': true
  ui:
    label: 'Counted Page'
```

The mixin extends the page with a `readcounter` property you can use as a sort property or render it somewhere
on the page.