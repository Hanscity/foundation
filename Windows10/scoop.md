# scoop

```

$env:SCOOP='S:\Scoop\Applications\Scoop'
[Environment]::SetEnvironmentVariable('SCOOP', $env:SCOOP, 'User')


$env:SCOOP_GLOBAL='S:\Scoop\GlobalScoopApps'
[Environment]::SetEnvironmentVariable('SCOOP_GLOBAL', $env:SCOOP_GLOBAL, 'Machine')
```




```



PS C:\Users\Administrator> sudo scoop install php --global
Installing 'php' (7.4.12) [64bit]
php-7.4.12-Win32-VC15-x64.zip (24.9 MB) [========================================================================] 100%
Checking hash of php-7.4.12-Win32-VC15-x64.zip ... ok.
Extracting php-7.4.12-Win32-VC15-x64.zip ... done.
Running pre-install script...
Linking S:\Scoop\GlobalScoopApps\apps\php\current => S:\Scoop\GlobalScoopApps\apps\php\7.4.12
Creating shim for 'php'.
Creating shim for 'php-cgi'.
Creating shim for 'phpdbg'.
Adding S:\Scoop\GlobalScoopApps\shims to global path.
Persisting cli
Persisting php.ini-production
Running post-install script...
'php' (7.4.12) was installed successfully!
'php' suggests installing 'extras/vcredist2017'.




PS C:\Users\Administrator> scoop install php
Installing 'php' (7.4.12) [64bit]
php-7.4.12-Win32-VC15-x64.zip (24.9 MB) [========================================================================] 100%
Checking hash of php-7.4.12-Win32-VC15-x64.zip ... ok.
Extracting php-7.4.12-Win32-VC15-x64.zip ... done.
Running pre-install script...
Linking ~\scoop\apps\php\current => ~\scoop\apps\php\7.4.12
Creating shim for 'php'.
Creating shim for 'php-cgi'.
Creating shim for 'phpdbg'.
Persisting cli
Persisting php.ini-production
Running post-install script...
'php' (7.4.12) was installed successfully!
'php' suggests installing 'extras/vcredist2017'.



```


