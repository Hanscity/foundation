## start byobu
* byobu

## 
* unset TMUX


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

## F1
* help

## packet_write_wait: Connection to 120.79.65.20 port 11022: Broken pipe
* output the error is well

* 方案一
   * ssh -o ServerAliveInterval=60 uersname@ip
   * -o 'IPQoS=lowdelay throughput'

* 方案二
   ```
   1、在~/.ssh/config配置文件中添加

　　　IPQoS lowdelay throughput

   2、在/etc/ssh/ssh_config配置文件中添加

　　　IPQoS lowdelay throughput

   3、临时解决可以再命令行中加入-o 'IPQoS=lowdelay throughput'参数即可

   ```