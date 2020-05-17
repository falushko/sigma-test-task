# Test task for Sigma Software

This library allows to create a POS Terminal and count a price for a shopping cart 
depending on different pricing strategies.

### How to install
TBD
### How to use

First create pricing strategies and add products:

```PHP
$pricing = new OneTierPricing();
$pricing->addProduct(new OneTierProduct('ZA', 2, 7, 4));
$pricing->addProduct(new OneTierProduct('YB', 12));
$pricing->addProduct(new OneTierProduct('FC', 1.25, 6, 6));
$pricing->addProduct(new OneTierProduct('GD', 0.15));
```

Then create a terminal and set pricing:

```PHP
$terminal = new POSTerminal();
$terminal->setPricing($pricing);
```

Scan items:

```PHP
$terminal->scanItem('ZA');
$terminal->scanItem('YB');
$terminal->scanItem('FC');
$terminal->scanItem('GD');
$terminal->scanItem('ZA');
$terminal->scanItem('YB');
$terminal->scanItem('ZA');
$terminal->scanItem('ZA');
```

And get a result:

```PHP
$totalPrice = $terminal->getTotal();
```

To clean items call:

```PHP
$terminal->resetItems();
```

### How to extend

This library utilizes Strategy design patter. You could extend it just implementing 
`PricingInterface` and `ProductInterface` and add your own pricing strategy (for 
example two or three tiers pricing strategy).