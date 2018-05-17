# Changelog

All important changes to `fiisoft-entity-id` will be documented in this file

## 2.1.0

* Added interface Entity and class GenericEntity
* File composer.lock excluded from versioning (by .gitignore)

## 2.0.0

Two new methods added to interface Id: compare and __toString.

## 1.4.0

Added abstract class StringId to encapsulate string IDs.

## 1.3.0

Abstract class TwoColumnsId added as parent class for TwoIntegersId

## 1.2.0

AbstractData got new method equals() and a primitive way to say why is not equal to given param. 

## 1.1.0

Added template method areValuesTheSame() to AbstractData.

## 1.0.0

First version of library.
