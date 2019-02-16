# c

## Linux C 一站式编程

### 部分 I. C语言的语法
#### 第一章. 程序的基本概念
1. 程序和编程语言
   * 程序由五种指令构成，输入，输出，运算，测试和分支，循环或递归。
   * 程序由编程语言组成。低级的编程语言由指令组成，高级的编程语言由语句或者是表达式组成。只是一种说法上的传统习惯吧。
   * 低级的编程语言只有两种：机器语言，汇编语言。汇编语言是机器语言的形象表达。编译器将汇编语言编译成机器语言，汇编语言和机器语言是一一对应的关系。
   * 硬件架构的不同，机器语言有所不同，汇编语言很难平台移植。
   * C 语言可以调用硬件，可以平台移植。独孤九剑的强大在于其思想，C 的强大在于其编译器。
   
2. 自然语言和形式语言
   * 初一数学，表达式一章，已经有所讲解。编程语言和表达式一般，都是形式语言，场景不同而已。
   
3. 程序的调试
   * bug分为三种，编译错误，运行错误，逻辑错误和语义错误。
   * 编译错误就是语法错误，逻辑错误和语义错误就是业务错误，运行错误是最不容易检测出来的，特别是高级语言。因为出现死循环，需要用 gdb来查看内存调用。

4. 第一个程序
   * 建议加上 -Wall选项
   
   * printf("Hello,world!\n");需要双引号哦。
   
    
#### 第二章 常量,变量和表达式
1. 继续 Hello World
   * 双引号是界定符
   * \n 是转义序列中的一种，Windows习惯使用 \r\n
   
2. 常量
   * 字符常量，数字常量，枚举常量
   * 字符常量需要单引号，双引号是会出错的。` printf("character: %c\ninteger: %d\nfloat %f\n",'{',34,3.14);`
   1. 习题一
      * ` printf("%c\n",'%');`
      
3. 变量
   * 定义和声明是不同的。申明就是申明；定义是在申明的基础上分配存储空间。
   
4. 赋值
   * 代码说明：
   
      ```
      char login_name;//申明
      login_name = 'a';//赋值
      char reg_name = 'b';//初始化，初始化就是定义的同时也赋值
      
     ```
5. 表达式
   * 运算符：+ - * / = 这些就是运算符
   * 运算数：常量和变量就是运算数
   * 表达式：由运算符和运算数组成
   * 表达式语句：表达式加上分号即是
   1. 运算符的结合性： 同样优先级的运算符是从左往右，还是从右往左，这称为运算符的结合性。+ - * / 是从左往右，是左结合；= 是右结合，也就是说多个等号是从右往左开始运算的。
   2. 表达式的优先级：* / 最高，+ - 次之，= 最低。
   3. 调用一个方法，在传递参数的时候，参数可以是表达式，会被优先计算。也可以是赋值的表达式。
        ```
        int hour = 4;
        int minutes = 48;
        int total_minutes;
        printf("hour: %d\nminutes: %d\ntotal_minutes: %d\n",hour,minutes,total_minutes=hour*60+minutes);
       ```
   4. 表达式语句不宜过度复杂，会增加阅读和调试的难度。
   
   * 对比一下 C和 PHP的除法运算
      ```
      // C的代码
      printf("hour_one:%d\n",48/60);//0
      printf("hour_two:%f\n",48/60.0);//0.800000
      
      // Php的代码
      echo (48/60)."\n";//0.8
      echo intval(48/60)."\n";//0

     ```
   
6. 字符类型和字符编码
    * 计算机展示出来，也就是我们所看到的，都是字符类型。而计算机本身只能识别数字，这需要一套转换规则，这就是字符编码。
    * Ascii码的转义表示
       ```
       
       printf("%c\n",'\53');//输出 +，默认使用 8进制
       printf("%c\n",'\x2B');//输出 +，16进制尽量使用小 x

       ``` 
              
 #### 第三章 简单函数
 
 1. 数学函数
    * C语言的函数可以利用其副作用(SIDE EFFECT)，这是和数学函数的主要区别。
    * gcc编译含有数学库的引入的时候，需要加入 -lm的选项，-lc的选项是默认的，一般省略了。lm代表 lib库下面的 libm.so,lc代表 lib库下面的 libc.so.
       ```
        gcc -Wall -lm -lc test001.c -o test001
       ```
       
 2. 自定义函数
    * 函数原型(prototype)，有且只有函数名，参数，返回值。
    * 函数申明，函数定义。函数申明就是有且只有函数原型的语句，函数定义就是函数申明加上函数体。类似于变量的申明和定义，特别是在内存的申请上。
        ```
            //函数原型
            void test(void)
            //函数申明
            void test(void);
            //函数定义
            void test(void){
                //do something...
            };
       ```
    * 编译器在编译函数的时候，至少需要函数申明，才能生成相关指令。如果连函数申明也没有，会进行默认的隐式转换。
    * void值是虚构出来的，不能参与计算。任何的表达式都会有一个值，如果函数表达式没有返回值，就会返回 void值，从而兼顾了语法上的一致性。
    
 3. 形参(parameter)和实参(argument)
    * 函数申明中的参数就是形参，函数调用中的参数就是实参。C语言的函数调用是采取调用传值的方式(call by value)。形参和实参是不同的变量，只不过保存了同样的数值，在调用之后。
    1. 习题解答
       * 没有预期的效果。函数调用之后，call by value,形参的值发生改变，执行运算，改变形参的值，并没有改变实参的值。
       
 4. 局部变量(Local Variable)和全局变量(Global Variable)
    * 作用域(Scope)
       1.局部变量和全局变量使用相同的变量名，局部变量会覆盖全局变量的作用域。
    * 函数中定义的变量就是局部变量，比如形参，就是局部变量。
       1. 不同的函数，定义相同的变量名，还是代表不同的变量。
       2. 相同的函数，每一次调用，变量都代表不同的存储空间。
    * 全局变量在编译的时候分配存储空间，所以它的定义必须是常量。在程序退出的时候，释放存储空间。
    * 必要条件(Necessary Condition)和充分条件(Sufficient Condition),在编程逻辑判断的时候，很容易将必要条件当做充分条件来理解。
    
    
#### 第四章 分支语句(Selection Statement)
1. if语句
   * 所有语句的地方，都可以写成语句块。语句块不需要加冒号结尾，如果加了冒号，那么冒号就形成了一个新的语句，不过是空的。
   * 语句块有独立的作用域，比函数的作用域更小。
   * PHP的语句块同样是如此的。
   
   1. 习题
      * `if(x>0);//这样的意思是，如果变量大于0，那么一个空语句。`
   


2. if/else语句
    * if/else语句最好加上{},否则，else会与最近的 if组合（这称为 Dangling-else问题）。
    1. 习题二的答案
       ```
       void printfTen(int i){
               printf("整数的十进制位是：%d\n",i/10);
               printf("整数的个位是：%d\n",i%10);
       }
       ``` 
       
3. 布尔代数
   * 对真值的逻辑运算称为布尔代数(Boolean Algebra)。
   * 逻辑非就是平常所说的条件取反，符号是 !(Exclamation Mark),属于单目运算符(Unary Operator)。
   * 单目运算符的优先级很高。这些运算符的优先级顺序是：!高于*/%，高于+-，高于>、<、>=、<=，高于==、!=，高于&&，高于||。
   * 逻辑运算数，0 表示假，非0 表示真；运算结果是 1 表示真，0 表示假。C和 Php都是如此。
   
4. switch语句
   * 总是没有记住格式。。
       ```
       switch(控制表达式){
            case 常量表达式:语句序列
            case 常量表达式:语句序列
            default:语句序列
       }
    
       ```   
   
## 第五章 深入理解函数

1. return语句
   * call by value(按值传递)，值会传递过去，变量的存储空间会被释放。return语句也是 call by value。
   * `- +`这两个符号分别是取负数，取正数，是属于单目运算符。
   
2. 增量式开发(incremental)
   * 增量式开发，就是每写一段代码，就去验证它的正确性，然后写下一段。一口气写完程序，是一个不好的习惯。
   * 减量式调试，如果碰到不易调试的程序。
   * 程序的脚手架(scaff):C语言的 printf，Php的 echo，或者输出日志到文件。这是最直接明了的调试，当程序正常运行后，一般会去掉或者注释掉这部分内容，就像盖房子的时候需要用到的脚手架一样。
   * 分层思想：程序需要分模块，方法需要分层。写一个大的函数方法的时候，需要一个小功能点一个方法，然后复用(reuse)。这一层一层的调用，如何判断最终的正确性呢，这就需要 Leap Faith。
   
3. 递归(recursive)
   * 自己调用自己，就是递归。
   * 递归需要有 Base Case,否则会形成无穷递归(Infinite recursion)。
   * 递归函数在执行的过程中，随着函数一次次的调用，在一个特定的存储结构中的一端不断增加，每一次调用都只能访问自己的存储空间，这个存储空间称为帧栈(Stack Frame),这个特定的存储结构称为堆栈(Stack)。在函数的最末端，一次次 return的时候，Stack开始一层层的释放。
   * 所有的递归可以用循环来写，反之亦然。Lisp语言只有递归，没有循环。

   1. 习题1
      ```
      int recursive(int a,int b){
      
              int min;
              int max;
              if(a > b){
                      max = a;
                      min = b;
              }else{
                      max = b;
                      min = a;
              }
      
              if(max%min == 0){
                      return min;
              }else{
                      return recursive(min,max%min);
              }
      }

      ```
      
#### 第 6 章   循环语句
1. while语句
   1. 习题一
   ```
   //递归的写法--函数式编程(Functional Programming)--Declarative(申明式)
   int factorial(int i){
           if(i == 0){
                   return 1;
           }else{
                   int j = factorial(i-1);
                   return i*j;
           }
   }
    
    //while的写法--命令式编程(Imperative Programing)--Imperative(必要，祈求，命令式)
    int while_func(int i){
        int j = 1;
        while(i > 0){
            int j = j * i;
            i = i - 1;
        }
        return j;
    }
    
    //do while 的写法
    int do_while_func(int i){
        int j = 1;
        do{
            int j = j * i;
            i = i - 1;
        }while(i > 0);
        
        return j;
    }
    
    //for 的写法
    int for_func(int n){
            int res = 1;
            int i;
            for(i=1;i<=n;i++){
                    res = res * i;
            }
    
            return res;
    }


   ```
   2. 习题二
   
   ```   
   #include <stdio.h>
   
   int find_nine(int n){
           int res = 0;
   
           while(n<=100){
                   if((n/10 == 9) || (n%10 == 9)){
                           res = res + 1;
                   }
                   n = n + 1;
           }
           return res;
   }
   int main(void){
           int res = find_nine(1);
           printf("1~100 have 9 count is %d\n",res);
           return 0;
   }
   
   ```
   3. 循环语句需要小心，因为有些复杂的条件不容易一眼看出，还有一些待验证的公式。比如 3x + 1 问题，至今无人证明。。
   
2. do/while 语句

3. for 语句
   * 前缀自增运算符(Prefix Increment Operator `++i`)，前缀自减运算符(Prefix Decrement Operator `--i`)，后缀自增运算符(Postfix Increment Operator `i++`)，后缀自减运算符(Postfix Decrement Operator `i--`)。如果看做函数的调用，前缀返回改变后的值，后缀返回改变之前的值，这是前缀和后缀的区别。在 for循环的语句中，使用的都是它们的 Side Effect，所以没有差别此时。
   
   * C99的一个标准
       ```    
       
       int for_func(int n){
               int res = 1;
               for(int i=1;i<=n;i++){
                       res = res * i;
               }
       
               return res;
       }
       //test1110.c:27: error: ‘for’ loop initial declarations are only allowed in C99 mode
       //test1110.c:27: note: use option -std=c99 or -std=gnu99 to compile your code
       //C++ 一般采取了这种写法，而在 C语言中，为了有更好的兼容性，一般不采取这种写法。
    
       ```

4. break和 continue语句
   1. 习题一
       ```   
       #include <stdio.h>
       
       int is_prime(int n){
       
               int i;
               for(i=2;i<n;++i){
                       if(n%i == 0){
                               return 0;
                       }
               }
               return 1;
       }
       
       void print_prime(int n){
       
               int i;
               for(i=1;i<=n;++i){
                       if(is_prime(i)){
                               printf("The prime is %d\n",i);
                       }
               }
       }
       int main(void){
       
               print_prime(100);
               return 0;
       
       }
    
       ``` 
   
   2. 习题二
      * for循环的 continue会去执行表达式三，while和 do while的 continue会去执行条件表达式，故有所不同。
      
      * 补充一点，break是一样的，对于所有的循环而言。
          ```  
          void break_for(void){
          
                  int i;
                  for(i=0;i<10;++i){
                          printf("The point is %d\n",i);
                          if(i == 5){
                                  printf("I will break on this point %d\n",i);
                                  break;
                          }
                  }
          }
          
          void break_while(void){
          
                  int i=0;
                  while(i<10){
                          printf("The point is %d\n",i);
                          if(i == 5){
                                  printf("I will break on this point %d\n",i);
                                  break;
                          }
                          ++i;
                  }
          }
          
          int main(void){
          
                  break_for();
                  break_while();
                  return 0;
          }
    
          //结果是：
          The point is 0
          The point is 1
          The point is 2
          The point is 3
          The point is 4
          The point is 5
          I will break on this point 5
          The point is 0
          The point is 1
          The point is 2
          The point is 3
          The point is 4
          The point is 5
          I will break on this point 5

          ```
          
   3. 一个额外的思考：sqrt(n)就够了？
       ```   
        //这段代码对比习题一的代码，结果是一样的
        int is_prime(int n){
        
                int i;
                for(i=2;i<sqrt(n);++i){
                        if(n%i == 0){
                                return 0;
                        }
                }
                return 1;
        }
        
        void print_prime(int n){
        
                int i;
                for(i=1;i<=n;++i){
                        if(is_prime(i)){
                                printf("The prime is %d\n",i);
                        }
                }
        }
    
       
       ```
       
 5. 嵌套语句
 
    1. 习题一: 打印小九九
    ```   
    void print_nine_nine(void){
    
            int i,j;
            for(i=1;i<=9;++i){
                    for(j=1;j<=9;++j){
                            if(i >= j){
                                    printf("%d ",i*j);
                            }
                    }
                    printf("\n");
            }
    }
    
    ```
    
6. goto语句
   * goto语句就是直接跳转到标识位(Label)的地方，适用于在一个方法内。这就是汇编中的 jmp命令。
   
   * goto语句也适用于 PHP。
      ```   
      for($i=0;$i<10;++$i){
      
              echo $i."\n";
              if($i == 6){
                      goto six;
              }
      }

      six:echo $i.'six'."\n";## 这里的 $i严格上说，应该报错。因为语法块的作用域没有到这个范围。在 C语言中是要报错的。 
      //输出的内容如下：
      0
      1
      2
      3
      4
      5
      6
      6six
            
      ```
   * goto语句在 C中的应用
      ```   
      for(int i=0;i<10;++i){
      
              printf("%d\n",i);
              if(i == 6){
                      goto six;
              }
      }

      six:printf("six..\n");
      
      //输出的结果如下：
      0
      1
      2
      3
      4
      5
      6
      six..

      
      ```
      
    * goto语句的历史争议和使用
    
       > 作为争论的结论，1974年Knuth发表了令人信服的总结，并证实了：
         （1）goto语句确实有害，应当尽量避免；
         （2）完全避免使用goto语句也并非是个明智的方法，有些地方使用goto语句，会使程序流程更清楚、效率更高。
         （3）争论的焦点不应该放在是否取消goto语句上，而应该放在用什么样的程序结构上。其中最关键的是，应在以提高程序清晰性为目标的结构化方法中限制使用goto语句
    
 
#### 第 7 章   结构体
1. 复合数据类型--结构体
   * 复合数据类型--Compound Type, 基本数据类型--Primitive Type
   * 复合数据类型既可以当做一个整体来访问，也可以访问每一个单元，这可以理解为数据抽象（Data Abstract）
   * 结构体有命名空间(Name Space)，命名空间其实就是特定的帧栈。
   * 罗马数字
      1. 作者用结构体来表达复数，我直接傻眼了，很久没有回忆起来，复数是什么玩意，原来我真的没有学过它。
      2. 复数由实数和虚数组成。实数由有理数和无理数组成。有理数可以由比值（分数）来表达，也就是说是整数，
   或者是小数位有限的小数，或者是小数位无限循环的小数。无理数是小数位无限不循环的小数。
      3. 2 的平方根就是无理数，通过勾股定理中的特例等腰三角形，可以得到 2的平方根。以下是证明 2的平方根
      是无理数 [wiki](https://zh.wikipedia.org/wiki/%E7%84%A1%E7%90%86%E6%95%B8#%E8%AD%89%E6%98%8E'%22%60UNIQ--postMath-0000002E-QINU%60%22'%E6%98%AF%E6%97%A0%E7%90%86%E6%95%B0)
      4. 公元前 500年左右，希腊的毕达哥拉斯学派，有很多伟大的证明，比如勾股定理等。他们认为万物皆数（有理       数），并形成了一套理论和信仰。他的学派弟子希帕索斯（Hippasus）却用勾股定理看到了无理数。当他说出这个秘密后，以亵渎神的罪名被处死。
      5. 虚数的理解，请看这篇中文翻译的文章，翻译的特别好，虽然有一点小错误。可以看出英文原著写的非常好。
      [from csbn](https://www.cnblogs.com/andywenzhi/p/5723807.html)
      
      
2. 数据抽象
   * 学习的例子以三角函数为例，暂时屏蔽
   
3. 数据类型标志
   * 学习的例子以三角函数为例，暂时屏蔽
   * 在以上的基础上增加了一个枚举（enum）类型
       ```    
       enum coordinate_type { RECTANGULAR, POLAR };       
       printf("%d %d\n", RECTANGULAR, POLAR);
       
       ```
4. 嵌套结构体
   * 结构体是一种递归定义。结构体的成员由数据类型定义，结构体也是数据类型中的一种。
   

## 第八章 数组
1. 数组的基本操作
   * 结构体是复合的数据类型，存储空间相邻的，成员可以是复合数据类型，也可以是简单的数据类型。数组也是这样。
   * 结构体可以用结构体赋值，但是数组不能。不能赋值，也就不能作为参数来传递了。
   * 习题
      ```    
      int i,count[4]={4,5,6,},j[4];
      for(i=0;i<4;++i){
              printf("count[%d]=%d\n",i,count[i]);
              j[i]=count[i];
      }
      
      for(i=0;i<4;++i){
              printf("j[%d]=%d\n",i,j[i]);

      }
      
      ```
   
2. 数组应用实例：统计随机数
    * C程序的编译基本分为两步，预编译+编译。预编译基本分两步：将引入的文件代码加载进去 + 预定义的常量替换进去
    * 以 #号开头的语法元素称为预处理指示(Preprocessing Directive)
    * 预编译的编译指示有两个：gcc -E 和 cpp(C Preprocessor)
    * 习题答案如下：
    
       ```   
       #include <stdio.h>
       #include <stdlib.h>
       
       #define N 20
       #define BASIC_NUM 10
       int a[N];
       
       void gen_random(int i)
       {
               for(int j=0;j<N;++j){
                       a[j] = rand()%i+BASIC_NUM;
               }
       
       }
       
       void print_random(void){
       
               for(int j=0;j<N;++j){
                       printf("a[j]=%d\n",a[j]);
               }
       }
       int main(void)
       {
               gen_random(BASIC_NUM);
               print_random();
               return 0;
       }
       
       ```
3. 数组应用实例：直方图
   * 优化统计随机数程序
      ```   
      
     #include <stdio.h>
     #include <stdlib.h>
     
     #define N 20
     #define BASIC_NUM 10
     int a[N];
     
     
     void gen_random(int i)
     {
             for(int j=0;j<N;++j){
                     a[j] = rand()%i;
             }
     
     }
     
     void print_random(void){
     
             for(int j=0;j<N;++j){
                     printf("a[%d]=%d\n",j,a[j]);
             }
     }
     
     int howmany(int i){
     
             int k=0,j;
             for(j=0;j<N;++j){
                     if(i == a[j]){
                             ++k;
                     }
             }
             return k;
     }
     int main(void)
     {
             gen_random(BASIC_NUM);
             print_random();
     
             int arrayRandom[10] = {};
             for(int j=0;j<N;++j){
     
                     ++arrayRandom[a[j]];
             }
     
             for(int k=0;k<BASIC_NUM;++k){
                     printf("%d\t%d\n",k,arrayRandom[k]);
             }
             return 0;
     }
      ```
   

4. 字符串
   * 平常所说的字符串其实可以仔细区分为两种，一种是字符串变量，一种是字符串字面值。
   * 字符串以八进制的 \0结尾，在计算机层面。
   * 代码表示如下：
      ```   
      #include <stdio.h>
      
      int main(void)
      {
      
              char str[] = "Hello,world\n";
              printf("%s",str);
              return 0;
      
      }
      
      ```

5. 多维数组(Multi-dimensional Array)
   * dimension英 [daɪˈmenʃn]   美 [dɪˈmɛnʃən, daɪ-]  
   n.尺寸;[复]面积，范围;[物]量纲;[数]次元，度，维
   adj.（石料，木材）切成特定尺寸的
   vt.把…刨成（或削成）所需尺寸;标出尺寸

   * brace 英 [breɪs]   美 [bres]  
             vt.支撑;系紧;准备，预备;振作起来
             vi.准备好;支持;打起精神
             n.支持物;铁钳，夹子;[语]大括号;绷紧（身体部位的）肌肉
             
   * 多维数组的初始化
      ```   
        //这不是好的初始化的方式，如果不明确指定第二维数组的初始化，
        //那么第二维的初始化，如下例所示，a[0][0] = 0;a[0][1] = 1;
        //a[0][2] = 2;a[0][3] = 3;a[0][4] = 4;
        int a[3][8] = {0,1,2,3,4};
        printf("The array is %d\n",a[1][1]);//0
        printf("The array is %d\n",a[0][2]);//2
         
        //gcc -Wall 20190201.c -o 20190201
        //20190201.c:27:15: warning: missing braces around initializer [-Wmissing-braces]
        //警告：初始化的时候，缺少大括号
        
        //这是好的初始化方式
        int a[3][8] = {{0,1,2},{3,4}};
        printf("The array is %d\n",a[1][1]);
        printf("The array is %d\n",a[0][2]);
                  
      ```
   * 二维数组在物理存储空间上是连续的，这种方式叫 Row-major
   
   * scissor,stone,cloth
      ```   
      #include <stdio.h>
      #include <stdlib.h>
      #include <time.h>
      int main(void)
      {
       char gesture[3][10] = { "scissor", "stone",
      "cloth" };
       int man, computer, result, ret;
       srand(time(NULL));
       while (1) {
              computer = rand() % 3;
              printf("\nInput your gesture (0-scissor 1-stone 2-cloth):\n");
       ret = scanf("%d", &man);
       if (ret != 1 || man < 0 || man > 2) {
              printf("Invalid input! Please input 0, 1 or 2.\n");
              continue;
       }
       printf("Your gesture: %s\tComputer's gesture: %s\n", gesture[man], gesture[computer]);
       result = (man - computer + 4) % 3 - 1;
       if (result > 0)printf("You win!\n");
       else if (result == 0)
       printf("Draw!\n");
       else
       printf("You lose!\n");
       }
      
      
       return 0;
      
      }
      ```
    

第九章 编码风格
* Thus, programs must be written for people to read, and only incidentally for machines to execute.
   * incidentally
     英 [ˌɪnsɪˈdentli]   美 [ˌɪnsɪˈdɛntli]  
     adv.顺便;附带;捎带;偶然地，不经意地
     
   
1. 缩进和空白
2. 注释
3. 标识符命名
   * 下划线是 Linux和 K&R的标准命名， CamelCase(驼峰法)是现代 C++的命名标准
4. 函数
5. indent工具
   * indent -kr -i8
   

第十章 gdb
* gdb可以观察到程序执行的每一个细节，是一个非常强大的调试工具。
* 调试的基本思想，永远都是分析，假设，验证。一般情况下，printf就足够使用。
gdb适合分析疑难的情况

1. 单步执行和跟踪函数调用
   * gcc -Wall(此参数用来最严格的提醒)
   * gcc -lc (此参数用来引入默认的 stdio.h的头文件)
   * gcc -g 
   * gdb file
   * help 
   * start
   * n(next)
   * s(step)
   * i(info)
   * i locals
   * 
   
      ```   
      (gdb) help
      List of classes of commands:
      
      aliases -- Aliases of other commands
      breakpoints -- Making program stop at certain points
      data -- Examining data
      files -- Specifying and examining files
      internals -- Maintenance commands
      obscure -- Obscure features
      running -- Running the program
      stack -- Examining the stack
      status -- Status inquiries
      support -- Support facilities
      tracepoints -- Tracing of program execution without stopping the program
      user-defined -- User-defined commands
      
      Type "help" followed by a class name for a list of commands in that class.
      Type "help all" for the list of all commands.
      Type "help" followed by command name for full documentation.
      Type "apropos word" to search for commands related to "word".
      Command name abbreviations are allowed if unambiguous.
      
      //start to translate
      * internal
        英 [ɪnˈtɜ:nl]   美 [ɪnˈtɜ:rnl]  
        1. connected with the inside of sth
        2. connected with a country's own affairs rather 
           than those that involve other countries
        3. happening or existing in your mind
        
      *  maintenance
         英 [ˈmeɪntənəns]   美 [ˈmentənəns]  
         1. the act of keeping sth in good condition by checking 
            or repairing it regularly
         2. money that sb must pay regularly to their former wife, husband or                    partner, especially when they have had children together
     
         * maintenance commands: 维护命令
       
      * obscure
        英 [əbˈskjʊə(r)]   美 [əbˈskjʊr]
         1. not well known
         2. difficult to understand
         * Obscure features: 难以理解的特性
              
      * abbreviation
        英 [əˌbri:viˈeɪʃn]   美 [əˌbriviˈeʃən]  
        1. a short form
      
      * ambiguous
        英 [æmˈbɪgjuəs]   美 [æmˈbɪɡjuəs]  
        1. sth is not sure
        
      * Command name abbreviations are allowed if unambiguous: 
        命令可以简写，如果确定
      
       
      ```
      
      
* ing
   1. gcc -g 查看一下英文文档的说明
   2. List of info subcommands---info locals