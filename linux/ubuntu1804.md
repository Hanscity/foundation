## ubuntu18.04 中，phpstorm 的 ctrl + alt + < 冲突
> https://askubuntu.com/questions/1041914/something-blocks-ctrlaltleft-right-arrow-keyboard-combination
* just do this
   ``` 
   gsettings set org.gnome.desktop.wm.keybindings switch-to-workspace-left "[]"
   gsettings set org.gnome.desktop.wm.keybindings switch-to-workspace-right "[]"
   ````
