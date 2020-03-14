
> https://packagist.org/packages/submit

```
Please make sure you have read the package naming conventions before submitting your package. The authoritative name of your package will be taken from the composer.json file inside the master branch or trunk of your repository, and it can not be changed after that.

Do not submit forks of existing packages. If you need to test changes to a package that you forked to patch, use VCS Repositories instead. If however it is a real long-term fork you intend on maintaining feel free to submit it.

If you need help or if you have any questions please get in touch with the Composer community.

```

```
convention
英 [kənˈvenʃn]   美 [kənˈvenʃn]  
n.
习俗;常规;惯例;(某职业、政党等成员的)大会，集会;(国家或首脑间的)公约，协定，协议
复数： conventions
记忆技巧：con 共同 + vent 来 + ion 表名词 → 大家来到一起 → 集会


trunk : 主干

```


> https://getcomposer.org/doc/05-repositories.md#vcs

```
VCS#
VCS stands for version control system. This includes versioning systems like git, svn, fossil or hg. Composer has a repository type for installing packages from these systems.

Loading a package from a VCS repository#
There are a few use cases for this. The most common one is maintaining your own fork of a third party library. If you are using a certain library for your project and you decide to change something in the library, you will want your project to use the patched version. If the library is on GitHub (this is the case most of the time), you can simply fork it there and push your changes to your fork. After that you update the project's composer.json. All you have to do is add your fork as a repository and update the version constraint to point to your custom branch. In composer.json, you should prefix your custom branch name with "dev-". For version constraint naming conventions see Libraries for more information.


Example assuming you patched monolog to fix a bug in the bugfix branch:

{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/igorw/monolog"
        }
    ],
    "require": {
        "monolog/monolog": "dev-bugfix"
    }
}
When you run php composer.phar update, you should get your modified version of monolog/monolog instead of the one from packagist.

Note that you should not rename the package unless you really intend to fork it in the long term, and completely move away from the original package. Composer will correctly pick your package over the original one since the custom repository has priority over packagist. If you want to rename the package, you should do so in the default (often master) branch and not in a feature branch, since the package name is taken from the default branch.

Also note that the override will not work if you change the name property in your forked repository's composer.json file as this needs to match the original for the override to work.

If other dependencies rely on the package you forked, it is possible to inline-alias it so that it matches a constraint that it otherwise would not. For more information see the aliases article.

Using private repositories#
Exactly the same solution allows you to work with your private repositories at GitHub and BitBucket:

{
    "require": {
        "vendor/my-private-repo": "dev-master"
    },
    "repositories": [
        {
            "type": "vcs",
            "url":  "git@bitbucket.org:vendor/my-private-repo.git"
        }
    ]
}
The only requirement is the installation of SSH keys for a git client.

```


- composer check message
```

Notice: One or more similarly named packages have already been submitted to Packagist. If this is a fork read the notice above regarding VCS Repositories.

```