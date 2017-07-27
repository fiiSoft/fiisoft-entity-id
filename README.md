# FiiSoft Entity Id

Very simple abstraction for ID of entities. By now it supports only the simplest implementation that encapsulates integer values.

My advice is - do not use it unless you are enough strong mentally to immune for such bad code. 

#### `Id`

Interface for whole family of Id classes.

#### `AbstractId`

Base abstract class for Id family with some implementation.

#### `IntegerId`

Abstract class for implementations that encapsulate single integer value.

#### `TwoColumnsId`

Abstract class for implementation that encapsulate compound keys composed of pair of arbitrary values.

#### `TwoIntegersId`

Abstract class for implementation that encapsulate compound keys composed of pair of integers values.

----------------------------------------------------------

#### `AbstractData`

Additional class designed as base for DTO classes that use Id objects. 
