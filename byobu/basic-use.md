## start byobu
* byobu

## F1
* help

## F2
* 打开一个新窗口

## F3
* 左移

## F4
* 右移

## 连接远程服务
* ssh -p port -o ServerAliveInterval=60 username@ip



## byobu sessions

> https://askubuntu.com/questions/891518/how-to-kill-a-byobu-session?newreg=9fc82e8665394eb6bbcd3c386f7f6820
```   
You can list byobu current sessions with:

* byobu list-session

You should see something like this: 
session_1: 1 windows (created Tue Feb  6 18:05:35 2018) [237x49]
session_2: 1 windows (created Tue Feb  6 18:05:44 2018) [237x49]
session_3: 1 windows (created Tue Feb  6 18:06:05 2018) [237x49]

The first word in every line is the session name.

So, to kill a single session you can do:

* byobu kill-session -t <session_name>

To kill session_2 in previous list, you can do:

byobu kill-session -t session_2

```

## 释放后台

* unset TMUX
