
## 释放后台

* unset TMUX


## translate

### NAME
* byobu - wrapper script for seeding a user's byobu configuration and launching a text based window manager (either screen or tmux)

### SYNOPSIS
       * byobu [options]

       * byobu-screen [screen options]

       * byobu-tmux [tmux options]

       * Options to byobu are simply passed through screen(1) or tmux(1).

### DESCRIPTION

* byobu is a script that launches a text based window manager (either screen(1) or tmux(1)) in the byobu configuration.  This enables the display of system information and status notifications within two lines at the bottom of the screen session. It also enables multiple tabbed terminal sessions, accessible through simple keystrokes.byobu currently defaults to using tmux(1) (if present) as the backend, however, this can be overridden with the byobu-select-backend(1) utility.

* Note that BYOBU_CONFIG_DIR=$XDG_CONFIG_HOME/byobu if defined, and $HOME/.byobu otherwise.


```
- comment

notification: official notice
strike: kick

keystroke: key strike

utility: the quality of useful  
         a service provided for public 

otherwise: apart from that 
           if situation is different


```



### BACKGROUND COLORS
       The background colors of the byobu status lines can be adjusted by editing the files $HOME/.byobu/color (for byobu-screen) and $HOME/.byobu/color.tmux (for  byobu-tmux).   The  command  Ctrl-Shift-F5 will change the background to a randomly selected color when running in byobu-tmux mode.  Simply remove those files to return to the default color configuration.


### STATUS NOTIFICATIONS
       byobu  supports  a  number  of unique and interesting status notifications across the lowest two lines in the screen.  Each status notification item is independently configurable, enabled and disabled by the configuration utility.  The guide below helps identify each status item (in alphabetical order):

       apport - symbol displayed if there are pending crash reports; {!} symbol displayed on the lower bar toward the left, in black on an orange background

       arch - system architecture; displayed on the lower bar toward the left, in the default text color on the default background color

       battery - battery information; display on the lower bar toward the right; - indicates discharging, + indicates charging, = indicates fully charged;  when charging or discharging, the  current battery  capacity as a percentage is displayed;  the colours green, yellow, and red are used to give further indication of the battery's charge state; you may override the detected battery by setting BATTERY=/proc/acpi/battery/BAT0 in $BYOBU_CONFIG_DIR/statusrc

       cpu_count - the number of cpu's or cores on the system; displayed in the lower bar toward the right in the default text color on the default background, followed by a trailing 'x'

       cpu_freq - the current frequency of the cpu in GHz; displayed in the lower bar toward the right in white text on a light blue background

       cpu_temp - the cpu temperature in Celsius (default) or Fahrenheit, configure TEMP=F or TEMP=C in $BYOBU_CONFIG_DIR/statusrc; displayed in the lower bar toward the right in yellow  text  on  a black background; you may override the detected cpu temperature device by setting MONITORED_TEMP=/proc/acpi/whatever in $BYOBU_CONFIG_DIR/statusrc


       custom - user defined custom scripts; must be executable programs of any kind in $BYOBU_CONFIG_DIR/bin; must be named N_NAME, where N is the frequency in seconds to refresh the status indicator, and NAME is the name of the script; N should not be less than 5 seconds; the script should echo a small amount of text to standard out, standard error is discarded; the indicator will be displayed  in  the  lower panel, in default colors, unless you manually specify the colors in your script's output; BEWARE, cpu-intensive custom scripts may impact your overall system performance and could upset your system administrator!  In fact, you can easily copy and modify any status script usually found in /usr/lib/byobu/* to your local $HOME/.byobu/ directory.

       ```
       	Example: $BYOBU_CONFIG_DIR/bin/1000_uname
           #!/bin/sh
           printf "\005{= bw}%s\005{-}" "$(uname -r)"

       ```



		```
		- comment
		identify: recognize

		alphabetical: the order list of 26 letters

		pend: ing,will have result

		capacity: the size of container

		trail: track

		script: a text of play

		intensive: doing much work in short time
		           doing sth extremely
		           done with a lot of care

		impact: have powerful influence

		upset: make sth unhappy

		```


       date - the system date in YYYY-MM-DD format, or you can set this to any valid strftime(3) you like in $BYOBU_CONFIG_DIR/datetime; displayed in the lower on the far right in the  default  text color on the default background

       disk  -  total  disk  space  available and total used on / directory; displayed in the lower bar on the far right in white text on a light purple background; override the default directory by specifying an alternate mount point with MONITORED_DISK=/wherever in $BYOBU_CONFIG_DIR/statusrc

       disk_io - instantaneous read/write througput in kB/s or MB/s over the last 3 seconds; displayed in the lower bar toward the right in white text on a light purple background with a leading '<' sign  indicating  'read  speed'  and  '>'  sign  indicating 'write speed'; override the default monitored disk by specifying an alternate device with MONITORED_DISK=/dev/sdb, and override the default DISK_IO_THRESHOLD=50 (kB/s) in $BYOBU_CONFIG_DIR/statusrc

       distro - OS/distribution name of the release running on the current system as reported by lsb_release(1) or /etc/issue; displayed in the lower bar in bold black text toward the left on a grey background; you may override the detected release with DISTRO=Whatever in $BYOBU_CONFIG_DIR/statusrc

       ec2_cost  -  an  estimation  of the cost of the current boot of the system in terms of the Amazon EC2 billing model; displayed in the lower bar toward the right in green text on a black back‐
       ground; the monetary units are US Dollars '$'; this plugin only works when an AWS-compatible metadata server is available at http://169.254.169.254

       entropy - a count of the system's current entropy in bytes; displayed in the lower bar toward the right in yellow text on a dark grey background; there is a leading 'e' to indicate 'entropy'

       raid - note very prominently if there is a RAID failure detected, in red blinking text on a white background; the term 'RAID' notes that there is something wrong with the RAID, and  if  there
       is a rebuild/resync in progress, the percent complete is also shown

       rcs_cost  -  an  estimation  of the cost of the current boot of the system in terms of the Rackspace Cloud Server billing model; displayed in the lower bar toward the right in green text on a
       black background; there is a leading '~' to indicate that this is an estimation, and the monetary units are US Dollars '$'

       fan_speed - cpu or system fan speed as reported by lm-sensors; displayed in the lower bar toward the right in black text on a grey background; there is a trailing 'rpm'  for  units;  you  may
       override the detected fan by setting FAN=/sys/path/to/your/fan1_input in $BYOBU_CONFIG_DIR/statusrc

       hostname  -  the  hostname  of  the  system;  displayed in the upper bar on the far right in bold black text on a grey background; there is a leading '@' symbol if the username status is also
       enabled

       ip_address - the IPv4 address of the system in dotted decimal form; displayed in the upper bar on the far right in bold black text on a grey background;  you can  override  and  display  your
       IPv6 address by setting 'IPV6=1', and you can show your external ip address by setting 'IP_EXTERNAL=1' in $BYOBU_CONFIG_DIR/statusrc

       ip_address4  -  the  IPv4  address  of  the  system in dotted decimal form; displayed in the upper bar on the far right in bold black text on a grey background;  you can show your external ip
       address by setting 'IP_EXTERNAL=1' in $BYOBU_CONFIG_DIR/statusrc

       ip_address6 - the IPv6 address of the system; displayed in the upper bar on the far right in bold black text on a grey background;  you can show your external ip address by setting 'IP_EXTER‐
       NAL=1' in $BYOBU_CONFIG_DIR/statusrc

       load_average - the system load average over the last 1 minute; displayed in the lower bar toward the right in black text on a yellow background

       logo  - an approximation of the current operating system's logo; displayed in the lower bar on the far left; you may customize this logo by setting a chosen logo in $BYOBU_CONFIG_DIR/logo, or
       you may override this with LOGO=:-D in $BYOBU_CONFIG_DIR/statusrc

       mail - system mail for the current user; the letter '[M]' is displayed in the lower bar toward the left in black text on a grey background

       memory - total memory available and used percentage in the system; displayed in the lower bar toward the right in white text on a green background

       menu - a simple indicator directing new users to use the F9 keybinding to access the byobu menu

       network - instantaneous upload/download bandwidth in [GMk]bps over the last 3 seconds; nothing is displayed if traffic is 0; displayed in the lower bar toward the left in white text on a pur‐
       ple  background  with  a  leading '^' sign indicating 'up' and 'v' sign indicating 'down'; override the default interface by specifying an alternate interface with MONITORED_NETWORK=eth1, and
       override the default units (bits) with NETWORK_UNITS=bytes, and override the default NETWORK_THRESHOLD=20 (kbps) in $BYOBU_CONFIG_DIR/statusrc

         
       notify_osd - Send on-screen notification messages to screen's notification buffer

       processes - total number of processes running on the system; displayed in the lower bar in white text on a dark yellow background with a trailing '&' indicating 'background processes'

       reboot_required - symbol present if a reboot is required following a system update; displayed in  the  lower  bar  white  text  on  a  blue  background  by  the  symbol  '(R)';  additionally,
       reboot_required  will  print '<F5>' in white text on a blue background, if Byobu requires you to reload your profile to affect some changes; it will also detect if your system is currently in
       powernap(8) state and if so print '.zZ'; if your system is currently performing an unattended-upgrade(1) you will see a white warning sign on a red background.

       release - OS/distribution name of the release running on the current system as reported by lsb_release(1) or /etc/issue; displayed in the lower bar in bold black text toward  the  left  on  a
       grey  background;  you  may  override  the  detected  release  with  RELEASE=Whatever  in  $BYOBU_CONFIG_DIR/statusrc;  you  may  also abbreviate the release string to N characters by setting
       RELEASE_ABBREVIATED=N in $BYOBU_CONFIG_DIR/statusrc

       services - users can configure a list of services to monitor, define the SERVICES variable in $BYOBU_CONFIG_DIR/statusrc, a whitespace separated of services, each service should  include  the
       init  name  of the service, then a pipe, and then an abbreviated name or symbol to display when running (e.g. SERVICES="ssh|ssh apache2|http"); displayed in the lower bar toward the center in
       cyan on a white background

       session - byobu session name (only supported in byobu-tmux(1)); displayed in the lower bar on the left in underlined black text on a white background

       swap - total swap space and total used as a percentage of the total available; displayed in the lower bar toward the right in black text on a light green background with a trailing '%' sign

       time - the system time in HH:MM:SS format (by default), or you can set this to any valid strftime(3) you like in $BYOBU_CONFIG_DIR/datetime; displayed in the lower bar on the far right in the
       default text and default background colors

       time_binary  -  only for the hard core geek, the local system time in binary; requires UTF-8 support in a VERY recent version of GNU Screen; displayed in the lower bar on the far right in the
       default text and background colors

       time_utc - the UTC system time in HH:MM format; displayed in the lower bar on the far right in dark text on a light background

       updates_available - the number of updates available on the system; displayed in the lower bar toward the right in white text on a red background with a trailing '!' sign; if any  updates  are
       marked 'security updates', then there will be a total of two trailing exclamation points, '!!'

       uptime - the total system uptime since last boot; displayed in the lower bar toward the right in blue text on a grey background

       users  -  the  number of remote users logged into the system via sshd, empty if 0 users; displayed in the lower bar toward the right in red text on a grey background with a trailing '#' sign;
       set USERS_DISTINCT=1 to instead count the number of distinct users logged into the system (rather than open ssh sessions)

       whoami - the name of the user who owns the screen session; displayed in the upper bar toward the far right in bold black text on a grey background

       wifi_quality - the connection rate and signal quality of the wifi connection; displayed in the lower bar toward the right in black text on a cyan background; the connection rate is in  'Mb/s'
       and the signal quality is as a percentage with a trailing '%'; override the default interface by specifying an alternate interface with MONITORED_NETWORK=wlan0 in $BYOBU_CONFIG_DIR/statusrc

SESSIONS
       Byobu name screen sessions "byobu", if unspecified.  To hide sessions from byobu-select-session(1), prepend a "." to the beginning of the session name, like:

        byobu -S .hidden

WINDOWS
       Each open window in the screen session is displayed in the upper bar toward the far left.  These are numbered, and include indicators as to activity in the window (see "activity" in screen(1)
       and tmux(1) for symbol definitions).  The current active window is highlighted by inverting the background/text from the rest of the window bar.

       Users can create a list of windows to launch at startup in $BYOBU_CONFIG_DIR/windows and $BYOBU_CONFIG_DIR/windows.tmux.  This file is the same syntax as ~/.screenrc and ~/.tmuxrc, each  line
       specifying a window, as described in screen(1) or tmux(1).


       User can also launch Byobu with unique window sets.  Users can store these as $BYOBU_CONFIG_DIR/windows.[NAME] and $BYOBU_CONFIG_DIR/windows.tmux.[NAME], and launch Byobu with the environment
       variable BYOBU_WINDOWS=NAME.

       For example:
         $ cat $BYOBU_CONFIG_DIR/windows.ssh_sessions
         screen -t localhost bash
         screen -t aussie ssh root@aussie
         screen -t beagle ssh root@beagle
         screen -t collie ssh root@collie

       Then:
         $ BYOBU_WINDOWS=ssh_sessions byobu

       For example:
         $ cat $BYOBU_CONFIG_DIR/windows.tmux.split4
         new-session 'bash' ;
         new-window -n term1 ;
         new-window -n term2 ;
         new-window -n ssh ssh 10.9.8.7 ;
         split-window ;
         split-window ;
         split-window ;
         select-layout tiled ;
         select-pane -t 0

       Then:
         $ BYOBU_WINDOWS=split4 byobu

UNITS OF MEASURE
       byobu uses binary for capacity measurements of KB, MB, GB, and TB.  This means multiples of 1024 rather than multiples of 1000, in accordance with JEDEC Standard 100B.01 for  memory  capacity
       measurements.  See:
        * http://en.wikipedia.org/wiki/JEDEC_memory_standards

       byobu uses decimal for measurements of network data transfer, meaning multiple of 1000, rather than 1024.  See:
        * http://en.wikipedia.org/wiki/Data_rate_units

KEYBINDINGS
       byobu keybindings can be user defined in /usr/share/byobu/keybindings/ (or within .screenrc if byobu-export was used). The common key bindings are:

       F2 - Create a new window

       F3 - Move to previous window

       F4 - Move to next window

       F5 - Reload profile

       F6 - Detach from this session

       F7 - Enter copy/scrollback mode

       F8 - Re-title a window

       F9 - Configuration Menu

       F12 -  Lock this terminal

       shift-F2 - Split the screen horizontally

       ctrl-F2 - Split the screen vertically

       shift-F3 - Shift the focus to the previous split region

       shift-F4 - Shift the focus to the next split region

       shift-F5 - Join all splits

       ctrl-F6 - Remove this split

       ctrl-F5 - Reconnect GPG and SSH sockets

       shift-F6 - Detach, but do not logout

       alt-pgup - Enter scrollback mode

       alt-pgdn - Enter scrollback mode

       Ctrl-a $ - show detailed status

       Ctrl-a R - Reload profile

       Ctrl-a ! - Toggle key bindings on and off

       Ctrl-a k - Kill the current window

       Ctrl-a ~ - Save the current window's scrollback buffer

SCROLLBACK, COPY, PASTE MODES
       Each window in Byobu has up to 10,000 lines of scrollback history, which you can enter and navigate using the alt-pgup and alt-pgdn keys.  Exit this scrollback mode by hitting enter.  You can
       also easily copy and paste text from scrollback mode.  To do so, enter scrollback using alt-pgup or alt-pgdn, press the spacebar to start highlighting text,  use  up/down/left/right/pgup/pgdn
       to select the text, and press enter to copy the text.  You can then paste the text using alt-insert or ctrl-a-].

BUGS
       For  Byobu colors to work properly, older versions of GNU Screen require a 1-line patch to adjust MAX_WINMSG_REND in screen.c.  The change is in GNU Screen's upstream source control system as
       of 2010-01-26, but GNU Screen has not released a new upstream version in several years.  You can disable colors entirely by  setting  MONOCHROME=1  in  $BYOBU_CONFIG_DIR/statusrc.   For  more
       information, see:
        * http://savannah.gnu.org/bugs/?22146

       PuTTY  users  have reported that the F2, F3, and F4 shortcut keys are not working properly.  PuTTY sends the same escape sequences as the linux console for F1-F4 by default.  You can fix this
       problem in the PuTTY config, Terminal -> Keyboard -> Function keys: Xterm R6.  See: http://www.mail-archive.com/screen-users@gnu.org/msg01525.html

       PuTTY users should configure enable UTF-8 characters in order to fix status refresh issues.  You can fix this problem in the PuTTY configuration, Window -> Translation: select UTF-8.

       PuTTY users should avoid resizing their window to one character tall, as this can sometimes crash byobu-screen.

       Ctrl-a R - Reload profile

       Ctrl-a ! - Toggle key bindings on and off

       Ctrl-a k - Kill the current window

       Ctrl-a ~ - Save the current window's scrollback buffer

SCROLLBACK, COPY, PASTE MODES
       Each window in Byobu has up to 10,000 lines of scrollback history, which you can enter and navigate using the alt-pgup and alt-pgdn keys.  Exit this scrollback mode by hitting enter.  You can
       also easily copy and paste text from scrollback mode.  To do so, enter scrollback using alt-pgup or alt-pgdn, press the spacebar to start highlighting text,  use  up/down/left/right/pgup/pgdn
       to select the text, and press enter to copy the text.  You can then paste the text using alt-insert or ctrl-a-].

BUGS
       For  Byobu colors to work properly, older versions of GNU Screen require a 1-line patch to adjust MAX_WINMSG_REND in screen.c.  The change is in GNU Screen's upstream source control system as
       of 2010-01-26, but GNU Screen has not released a new upstream version in several years.  You can disable colors entirely by  setting  MONOCHROME=1  in  $BYOBU_CONFIG_DIR/statusrc.   For  more
       information, see:
        * http://savannah.gnu.org/bugs/?22146

       PuTTY  users  have reported that the F2, F3, and F4 shortcut keys are not working properly.  PuTTY sends the same escape sequences as the linux console for F1-F4 by default.  You can fix this
       problem in the PuTTY config, Terminal -> Keyboard -> Function keys: Xterm R6.  See: http://www.mail-archive.com/screen-users@gnu.org/msg01525.html

       PuTTY users should configure enable UTF-8 characters in order to fix status refresh issues.  You can fix this problem in the PuTTY configuration, Window -> Translation: select UTF-8.

       PuTTY users should avoid resizing their window to one character tall, as this can sometimes crash byobu-screen.

       Apple Mac OSX terminal users have reported 'flashing text'.  You can fix this in the advanced settings of the terminal application, with 'Declare Terminal As: xterm-color'.

       Apple Mac keyboard users may need to specify a vt100 terminal by adding this to your OSX profile, in order to get Byobu's function keys and colors to work:
         alias ssh='TERM=vt100 ssh'

       Users of a non-UTF-8 locale (such as cs_CZ charset ISO-8859-2), may need to add "defutf8 off" to ~/.screenrc, if some characters are rendering as "?".

       Users who customize their PS1 prompt need to put this setting in ~/.bashrc, rather than ~/.profile, in order for it to work correctly with Byobu.

       If you run byobu(1) under sudo(8), you must use the -H option, such that the user's $HOME directory environment variable is set properly.  Otherwise, byobu(1) will create a bunch of  directo‐
       ries in the $SUDO_USER's $HOME, but will be owned by root.  To prevent this from happening, byobu(1) will simply refuse to run if $USER does not own $HOME.

       Byobu  requires  a  suitable  ulimit(3) values to run.  If you get an error at startup saying, 'pipe: too many open files', then check your ulimit -a values, as your "open files" or "max user
       processes" are too low.  In this case, you will probably need to run simple screen(1)

SEE ALSO
       screen(1), byobu-config(1), byobu-export(1), byobu-status(1), byobu-status-detail(1), byobu-enable(1), byobu-launch(1), byobu-select-backend(1), tmux(1)
       http://byobu.org

AUTHOR
       This manpage and the utility were written by Dustin Kirkland <kirkland@byobu.org> for Ubuntu systems (but may be used by others).  Permission is granted to copy, distribute and/or modify this
       document and the utility under the terms of the GNU General Public License, Version 3 published by the Free Software Foundation.

       The complete text of the GNU General Public License can be found in /usr/share/common-licenses/GPL on Debian/Ubuntu systems, or in /usr/share/doc/fedora-release-*/GPL on Fedora systems, or on
       the web at http://www.gnu.org/licenses/gpl.txt.

byobu                                                                                        19 June 2009                                                                                     byobu(1)

