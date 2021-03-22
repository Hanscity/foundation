# Ruan Yi Feng
> https://wangdoc.com/javascript/

## doubt 

- console.log(),why undefined?



- resume script execution(F8)
   - paused in debugger
   - step over next function call(F10)

```
for(var i = 0; i < 5; i++){
  console.log(i);
  if (i === 2) debugger;
}


```


## js 语法之 ...

```

const itemArr = [...this.data.items, newItem];

```

这是js的语法，等号右边的中括号，表示要重新定义一个数组。中括号内，就放一个个的数组元素。 ...（三个点） 代表展开数组，可以简单理解为把this.data.items中的每个元素，复制到中括号里了，然后再新加了一个 newItem元素，最终的目的是把this.data.items追加一个新元素，再返回给itemArr。

