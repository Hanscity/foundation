# PSR-4 Meta Document

1. [Summary](https://www.php-fig.org/psr/psr-4/meta/#1-summary)
The purpose is to specify the rules for an interoperable PHP autoloader that maps namespaces to file system paths, and that can co-exist with any other SPL registered autoloader. This would be an addition to, not a replacement for, PSR-0.

2. [Why Bother?](https://www.php-fig.org/psr/psr-4/meta/#2-why-bother)

## History of PSR-0

The PSR-0 class naming and autoloading standard rose out of the broad acceptance of the Horde/PEAR convention under the constraints of PHP 5.2 and previous. With that convention, the tendency was to put all PHP source classes in a single main directory, using underscores in the class name to indicate pseudo-namespaces, like so:


```

/path/to/src/
    VendorFoo/
        Bar/
            Baz.php     # VendorFoo_Bar_Baz
    VendorDib/
        Zim/
            Gir.php     # Vendor_Dib_Zim_Gir

```

```
- comment
broad: wide
convention: the common way of most people use

constraint:limit sth
tend: sth will happended
tendency: the status will happended
pseudo: sth is not the thing

```


With the release of PHP 5.3 and the availability of namespaces proper, PSR-0 was introduced to allow both the old Horde/PEAR underscore mode and the use of the new namespace notation. Underscores were still allowed in the class name to ease the transition from the older namespace naming to the newer naming, and thereby to encourage wider adoption.

/path/to/src/
    VendorFoo/
        Bar/
            Baz.php     # VendorFoo_Bar_Baz
    VendorDib/
        Zim/
            Gir.php     # VendorDib_Zim_Gir
    Irk_Operation/
        Impending_Doom/
            V1.php
            V2.php      # Irk_Operation\Impending_Doom\V2
This structure is informed very much by the fact that the PEAR installer moved source files from PEAR packages into a single central directory.

## Along Comes Composer
With Composer, package sources are no longer copied to a single global location. They are used from their installed location and are not moved around. This means that with Composer there is no “single main directory” for PHP sources as with PEAR. Instead, there are multiple directories; each package is in a separate directory for each project.

To meet the requirements of PSR-0, this leads to Composer packages looking like this:
```

vendor/
    vendor_name/
        package_name/
            src/
                Vendor_Name/
                    Package_Name/
                        ClassName.php       # Vendor_Name\Package_Name\ClassName
            tests/
                Vendor_Name/
                    Package_Name/
                        ClassNameTest.php   # Vendor_Name\Package_Name\ClassNameTest

```

The “src” and “tests” directories have to include vendor and package directory names. This is an artifact of PSR-0 compliance.

Many find this structure to be deeper and more repetitive than necessary. This proposal suggests that an additional or superseding PSR would be useful so that we can have packages that look more like the following:

```

vendor/
    vendor_name/
        package_name/
            src/
                ClassName.php       # Vendor_Name\Package_Name\ClassName
            tests/
                ClassNameTest.php   # Vendor_Name\Package_Name\ClassNameTest

```

This would require an implementation of what was initially called “package-oriented autoloading” (as vs the traditional “direct class-to-file autoloading”).


##  Package-Oriented Autoloading
It’s difficult to implement package-oriented autoloading via an extension or amendment to PSR-0, because PSR-0 does not allow for an intercessory path between any portions of the class name. This means the implementation of a package-oriented autoloader would be more complicated than PSR-0. However, it would allow for cleaner packages.

Initially, the following rules were suggested:

Implementors MUST use at least two namespace levels: a vendor name, and package name within that vendor. (This top-level two-name combination is hereinafter referred to as the vendor-package name or the vendor-package namespace.)

Implementors MUST allow a path infix between the vendor-package namespace and the remainder of the fully qualified class name.

The vendor-package namespace MAY map to any directory. The remaining portion of the fully-qualified class name MUST map the namespace names to identically-named directories, and MUST map the class name to an identically-named file ending in .php.

Note that this means the end of underscore-as-directory-separator in the class name. One might think underscores should be honored as they are under PSR-0, but seeing as their presence in that document is in reference to transitioning away from PHP 5.2 and previous pseudo-namespacing, it is acceptable to remove them here as well.


```
- comment
orient: toward sth
intercessory:make sth ajust
complicate: difficult

```

