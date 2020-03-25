export NVM_DIR="$([ -z "${XDG_CONFIG_HOME-}" ] && printf %s "${HOME}/.nvm" || printf %s "${XDG_CONFIG_HOME}/nvm")" [ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh" # This loads nvm



export NVM_DIR="$HOME/.nvm" [ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh" 



mi@mi-TM1701:~/Downloads$ curl -o- https://raw.githubusercontent.com/creationix/nvm/v0.33.11/install.sh | bash
  % Total    % Received % Xferd  Average Speed   Time    Time     Time  Current
                                 Dload  Upload   Total   Spent    Left  Speed
100 12819  100 12819    0     0   3907      0  0:00:03  0:00:03 --:--:--  3907
=> Downloading nvm from git to '/home/mi/.nvm'
=> Cloning into '/home/mi/.nvm'...
remote: Enumerating objects: 267, done.
remote: Counting objects: 100% (267/267), done.
remote: Compressing objects: 100% (239/239), done.
remote: Total 267 (delta 31), reused 85 (delta 18), pack-reused 0
Receiving objects: 100% (267/267), 119.47 KiB | 8.00 KiB/s, done.
Resolving deltas: 100% (31/31), done.
=> Compressing and cleaning up git repository

=> Appending nvm source string to /home/mi/.bashrc
=> Appending bash_completion source string to /home/mi/.bashrc
=> Close and reopen your terminal to start using nvm or run the following to use it now:

export NVM_DIR="$HOME/.nvm"
[ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"  # This loads nvm
[ -s "$NVM_DIR/bash_completion" ] && \. "$NVM_DIR/bash_completion"  # This loads nvm bash_completion
