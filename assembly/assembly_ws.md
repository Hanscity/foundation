# Assembly



## 序言



- 汇编语言是数据结构，操作系统，微机原理的重要基础


-  我希望这一次的过程是循序渐进的，所以选择了 8086CPU。（不是 AE86 哈。

   这是 INTEL 系列的命名方式，发展过程是 8080，8086/8088，80186，80286，80386，
   
   Pentium，PentinumII。。。）


###     80386 及以后的 WINDOWS 操作系统的三种模式

- 实时模式（8086 不具备实现一个完善的多任务操作系统功能，简而言之，单任务的）

- 保护模式

- 虚拟模式：可以在保护模式和实时模式之间切换，在现代的 Windows 操作系统中，当你打开      
  DOS，本质上就是从保护模式切换到了实时模式。反之依然。。
  
  
### 为何选择 8086CPU ？

- 通过以上的对比，可以看出，8086 的环境，更为简单，不会受到保护模式等干扰，适合学习

- 同时，作为承上启下的重要版本，基本拥有了所有内容



## 第一章 基础知识 



### 1.1 机器语言



- 机器语言简称 0，1 代码



- CPU 将 0，1 代码的集合转化为一系列的高低电频，使相关的电子器件受到驱动，进行计算



- 每一种微处理器（CPU），由于硬件设计和内部结构的不同，就需要不同的电平脉冲来控制，所有都有自己的一套机器指令集，也就是机器语言。





#### 8086CPU 完成运算 s = 768 + 12288 - 1280

```assembly
10111000000000000000000011

00000001000000000000110000

00101101000000000000000101
```

- 这样的代码，如果有错误，难以查找





### 1.2 汇编语言的产生

```mermaid
graph LR
    A(程序员)-->B[汇编指令]-->C{编译器}-->D[机器码]-->E[计算机]

```



#### 汇编代码和机器码是一一对应的

```
;操作：寄存器 BX 的内容送到 AX 中
;机器指令： 1000100111011000
;汇编指令： mov,ax,bx
```


- 所以，任何的语言都是可以转换成汇编语言的，对吗？



### 1.3 汇编语言的组成

1. 汇编指令：机器码的助记符，有对应的机器码
2. 伪指令：没有对应的机器码，有编译器执行，计算机并不执行
3. 其他符号：如 +、-、*、/ 等，由编译器识别，没有对应的机器码



### 1.4 存储器

- 存储器俗称内存
- 指令和数据在存储器中存放
- 首先是了解 CPU 是如何从内存中读取消息，以及想内存中写入消息的 



### 1.5 指令和数据

- 指令和数据是应用上的概念。在内存和磁盘上，指令和数据没有任何区别，都是二进制数据
- 什么时候看作指令，什么时候看作数据呢？这有关于指令段和数据段的指定规则哈，具体操作往下。



### 1.6 存储单元

- 一般微型存储器（内存）的存储单位是 Byte(字节)(这一点很重要，这决定了后面很多的计算)
- 1Byte = 8bit ; 1KB = 1024B; 1MB = 1024 KB; 1GB = 1024MB; 1TB = 1024GB;
- 电子计算机最小的信息单位是 bit(比特),也就是一个二进制位



### 1.7 CPU 对存储器的读写

- 存储单元的地址（地址信息）
- 器件的选择，读或写的命令（控制信息）
- 读或写的数据（数据信息）



#### 总线

- 计算机中专门有连接 CPU 和其他芯片的导线，通常称为总线。总线从逻辑上分为 3 类，地址总线，控制总线，数据总线

  

### 1.8 地址总线

- CPU 是通过地址总线来指定存储器单元的。举例说明：80386 CPU的地址总线的宽度为 32 位，那么最大的内存寻址为 2 的 32次方个内存单元
  
```
  2 * 2 * 1024 * 1024 * 1024 Byte=  4GB 
```



### 1.9 数据总线

- 8086 有 16 根数据线，可以一次传送 16 位数据，例如可以一次传送 89D8H

  ```
  1000 1001 1101 1000
  ```

  

  

### 1.10 控制总线

- 控制总线在这里是一个总称，控制总线的宽度决定了 CPU 对外部器件的控制能力。例如：对内存的读写



### 1.11 内存地址空间（概述）

- 地址宽度为 10，可以寻址 1024 个内存单元，这 1024 个可寻到的内存单元就构成了 CPU 的内存地址空间



### 1.12 主板

- 主板上有核心器件和一些主要器件，这些器件通过总线相连。这些器件有 CPU、存储器、外围芯片组、

  扩展插槽等。扩展插槽上一般有 RAM 内存条和各类接口卡。



### 1.13 接口卡

- CPU 通过总线向接口卡发送命令，接口卡根据 CPU 的命令控制外设进行工作



### 1.14 各类存储器芯片

#### 读写属性

-  RAM（Random Memory，随机存储器）
- ROM （Read Only Memory，只读存储器）



#### 功能和连接

- 主板上的 RAM
- ROM（BIOS（Basic Input/Output System））
- 接口卡上的 RAM （显存）



### 1.15 内存地址空间

- 基于一个计算机硬件系统编程的时候，必须知道这个系统中的内存地址空间的分配情况。
- 8086 的内存地址空间的分配情况如下
  1. 00000～9FFFF ： 主存储器地址空间 （RAM）
  2. A0000～BFFFF ：显存地址空间
  3. C0000～FFFFF ： 各类 ROM 地址空间





## 第二章 寄存器



- 内部总线实现了 CPU 内部各个器件之间的联系，外部总线实现 CPU 和主板上其他器件的联系。在 CPU 中：
  * 运算器进行信息处理
  * 寄存器进行信息存储
  * 控制器控制各种器件进行工作
  * 内部总线连接各种器件，在它们之间进行数据的传送
- 对于一个汇编程序员来说，CPU 中的主要部件是寄存器。通过改变寄存器中的内容来实现对 CPU 的控制。
- 8086 有 14 个寄存器，分别是： AX, BX, CX, DX, SI, DI, SP, BP, IP, CS, SS, DS, ES, PSW



### 2.1 通用寄存器

- AX, BX, CX, DX 这四个寄存器通常用来存放一般性的数据，被称为 通用寄存器

- 8086CPU 的所有寄存器都是 16 位的

- 8086CPU 的上一代 CPU 中的寄存器都是 8 位，为了保证兼容，AX, BX, CX, DX  可分为两个独立使用的 8 位

  寄存器来用

  ```Assembly
  AX                0100 1110  0010 0000                        4E20H         
  
  AH                0100 1110                                    4EH
  
  AL                0010 0000                                    20H
  ```

  

### 2.2 字在寄存器中的存储

-  处于兼容性的考虑，8086CPU 可以一次处理两种尺寸的数据，字节（byte），字（word,有两个字节组成）
- 高位字节放在 AH 中，低位字节放在 AL 中



### 2.3 几条汇编指令

- 结果为：ax=044CH, bx=8226H

| 程序段中的指令 | 执行后 AX 中的数据 | 执行后 BX 中的数据 |
| -------------- | ------------------ | ------------------ |
| 初始化         | 0000H              | 0000H              |
| mov ax,4E20H   | 4E20H              | 0000H              |
| add ax,1406H   | 0000H              | 0000H              |
| mov bx,2000H   | 0000H              | 0000H              |
| add ax,bx      | 0000H              | 0000H              |
| mov bx,ax      | 0000H              | 0000H              |
| add ax,bx      | 0000H              | 0000H              |





### 2.4 物理地址

- 每一个内存单元在这个空间中都有唯一的地址，这个唯一的地址称为物理地址



### 2.5 16 位结构的 CPU

- 运算器一次最多可以处理 16 位的数据
- 寄存器的最大宽度为 16 位
- 寄存器和运算器之间的通路为 16 位



### 2.6 8086CPU 给出物理地址的方法

- 8086CPU 地址总线的宽度为 20 位，寻址能力 1MB
  
    ```
    1024*1024*byte = 1MB
    ```

  

- 物理地址 = 段地址*16 + 偏移地址

  ![8086CPU 相关部件的逻辑结构](https://s1.ax1x.com/2020/09/24/0Sg9XD.jpg)





### 2.7 "段地址 * 16 + 偏移地址 = 物理地址" 的本质含义

- 本质含义是为了得到内存单元的物理地址。（其实就是因为地址总线的宽度为 20 位，寄存器为 16 位导致的）



### 2.8 段的概念

- 内存本没有段，本没有地址，这些概念和段的划分来自于 CPU。



### 2.9 段寄存器

- 8086CPU 有 4 个段寄存器： CS，DS，SS，ES

  

- 段寄存器提供段地址(言外之意,段地址就得段寄存器提供,普通寄存器无法使用这种方式)



### 2.10 CS 和 IP

- CS 为代码段寄存器，IP 为指令指针寄存器

  

- 在 8086CPU 中，任意时刻，设 CS 中的内容为 M，IP 中的内容为 N，8086CPU 将从内存 M*16 + N 单元开始读取一条指令并执行

  

- 以下主要是逻辑结果和宏观过程，屏蔽了 CPU 的物理结构以及具体的工作细节 
  
  
  ![CPU 执行图](https://s1.ax1x.com/2020/09/24/0pQUAA.jpg)

  
  



### 2.11 修改 CS、IP的指令

-    mov 指令被称为传送指令，可以改变大部分寄存器的值
-    jmp 指令被称为转移指令，可以用来修改 CS、IP 的值

   1.    jmp 段地址：偏移地址（jmp 2AE3:3,执行后：CS=2AE3H，IP=0003H，CPU将从 2AE33H 处读取指令）
   2.    jmp 某个合法寄存器（jmp ax; 执行后，CS 不变，IP=ax）



### 2.12 代码段

- 代码段来自于人为的定义
- 如何使代码段中的代码被执行呢？需要将 CS、IP 指向代码段的内存地址



### 实验 1 查看 CPU 和内存，用机器指令和汇编指令编程

- 基础环境安装：
 > https://blog.csdn.net/qq_19782019/article/details/88913885

- 在 debug 中来调试程序，需要分清是汇编指令还是 debug 命令哈

   ```assembly
  debug
  -r    ;查看寄存器的情况，或者修改寄存器的值
  -d    ;查看内存，以数据的形式展示
  -u    ;查看内存，以汇编指令的形式展示
  -e    ;在内存中写入数据
  -a    ;在内存中写入汇编指令
  -t    ;执行
  
  
  ```

  

- 将 2.3 实现,代码分析

  ![debug_001_r.jpg](https://i.loli.net/2020/09/25/uTlnVXO1rLF8JtK.jpg)
  ![debug_002_u.jpg](https://i.loli.net/2020/09/25/v2lKQ6N5tOMIfdW.jpg)
  ![debug_003_cs.jpg](https://i.loli.net/2020/09/25/3xgf7sElcKqtWuZ.jpg)
  ![debug_004_t.jpg](https://i.loli.net/2020/09/25/CoE4vgmLsaizpwt.jpg)
  ![debug_005_t.jpg](https://i.loli.net/2020/09/25/mOr81t2g5w9iLID.jpg)





## 第三章 寄存器和内存访问



### 3.1 内存中字的存储

- CPU 中，用 16 位寄存器来存储一个字。高 8 位存放高位字节，低 8 位存放低位字节

- 子单元，即存放一个字型数据（16位）的内存单元，由两个地址连续的内存单元组成



### 3.2 DS 和 [address]

```
mov bx,1000H
mov ds,bx
mov al,[0]
```

- 将内存 ds:[0] 中的字节内容赋值给寄存器 al
  - ds 寄存器是用来表示内存的段寄存器
  - ds 寄存器不允许直接赋值



### 3.3 字的传送

```
mov bx,1000H
mov ds,bx
mov ax,[0]            ;将 1000:0 中的字型数据送入 ax
mov [0],cx            ;将 cx 中的内容赋值给内存中的 1000:0
```



### 3.4 mov、add、sub 指令

```
;mov 赋值
;add 增加
;sub 减少

mov ax,8; ok
mov ax,bx; ok
mov ax,[0]; ok
mov [0],ax; ok
mov [0],62; error
mov ds,ax; ok

;add,sub 指令类似，例外是 add ds,ax; add ax,ds; 都是不可以的

```



### 3.5 数据段

- 数据段是一种安排，将 ds 赋值到相应的地方即可



### 3.6 栈

- 栈的这种操作规则被称为 ：LIFO（last In First Out,后进先出）



### 3.7 CPU 提供的栈机制

- 任意时刻，ss:sp 指向栈顶元素
- push ax 表示将 ax 的数据送入栈中, pop ax 表示将栈顶的元素取出赋值给 ax
- 8086CPU 的入栈和出栈都是以字为单位进行的



### 3.8 栈顶越界的问题

- 8086CPU 没有相关的约束和设置，小心操作



### 3.9 push，pop 指令

- push 和 pop 指令有两种操作方式

  ```assembly
  push 寄存器/内存单元    ;将寄存器或者某内存单元中的内容入栈
  pop 寄存器/内存单元    ;将寄存器或者某内存单元中的内容接受出栈的内容
  ```

  

- push 指令的执行步骤

  1. sp = sp -2;

  2. 向 ss:sp 指向的子单元中送入数据

     

- pop 指令的执行步骤

  1. 从 ss:sp 指向的子单元中读取数据
  2. sp = sp + 2



- push 和 pop 指令执行之后，栈中的内容会传送出去，但是栈中本身的值会有改变，也不是 0

  

- 代码分析,CPU 栈操作时 sp 的变化
  
  ![asm_push_001.jpg](https://i.loli.net/2020/09/30/vN4IuPKr9HyOjMf.jpg)
  ![asm_push_002.jpg](https://i.loli.net/2020/09/30/vN4IuPKr9HyOjMf.jpg)
  ![asm_push_003.jpg](https://i.loli.net/2020/09/30/qa7PGBEI9Mtzm4i.jpg)

### 3.10 栈段

- 根据需要，我们可以将一组连续的内存单元定义为一个栈段

- 通过上图,可以看出,代码段起始于 073F:010A, 栈段起始于 073F:00FD, 定义的数据段起始于 073F: N.

  如果一上来, pop 数据段,那就兵荒马乱了~所以小心操作; 一般来说,会将这几个段分开,比如 CS = 073F,

  SS = 373F,DS = 673F,这样操作失误的可能性就小了很多.其实,成熟系统(例如 Windows, Linux 等)的

  系统调用,是有保护这些段的,绝大部分状态下,用户无法操作到那一层.所以,也不好玩呗~_~

  



## 第四章 第一个程序



- 啥，这特么还没有开始？

- 是的，之前的程序和调试都是在 debug 中进行的，相当于 javascript 在浏览器的控制台中进行


#### 第一个汇编程序

   ```assembly
assume cs:codesg    ;将程序指向 codesg 这个程序段

codesg segment    ;segment 开始
				  ; codesg 标注这个程序段

    mov ax,2000h
    mov ss,ax
    mov sp,0
    add sp,10
    pop ax
    pop bx
    push ax
    push bx
    pop ax
    pop bx


    mov ax,4c00h    ;以下两条命令,表示程序返回
    int 21h


codesg ends    ;segment end

end    ; program end

   ```



- 生成目标文件

  ```
  >masm assems\t1.asm     ;assems 是指定目录
  >Object filename [T1.OBJ]:   assems\t1.obj;    ;分号表示结束，将会生成 assems\t1.obj 文件
  
  ```

  

- 连接目标文件

  ```
  >link assems\t1.obj    ;assems 是制定目录
  >Run File [T1.EXE]:  assems\t1.exe;    ;分号表示结束，将会生成 assems\t1.exe 文件
  ```

  

- 执行方式一

  ```
  >assems\t1.exe
  ```

  

- 执行方式二

  ```
  >debug assems\t1.exe
  ```
  ![assembly_debug_in_001.jpg](https://i.loli.net/2020/09/30/hPtRmHWTFkZsy3D.jpg)
  
  



#### 程序分析

- DOS 在运行程序时，是 command 将程序加载入内存，程序结束后将会返回到 command 中。（闪烁的 > 
  就是 command 程序的待机状态）

  

- ds = 075A, ss = 076A, IP = 0000 ,是有原因的。中间一定会预留 256 byte 为程序段前缀，称为 PSP。DOS 需要利用 PSP 来和被加载程序进行通信。(这一段,不必深究,先记着~,话说,这本书最精妙的地方,就是告诉你所有的细节,然后和你说哪个是重点,哪个先不需要研究,知道有这个东西,就可以了.)

  

- -u 指令用来查看当前 CPU 所指向的代码段,可以看出,代码已经加载入内存

  

- -t, 执行之. 显示出 "int 21", 此时使用 P 指令执行之,显示 "Program terminated normally" .

   完美收官哈~.啥? 你想问,为啥突然变成  P ?,这...是中断机制,或许下回分解吧~_~

  

### 扩展 1: Linux 上的汇编程序

#### 不同位数的寄存器命名特点

- 16-bit registers `AX, BX, CX` 

  32-bit registers `EAX, EBX, ECX`

  64-bit registers `RAX, RBX, RCX`

  

#### Intel 风格 && AT&T 风格

> https://www.ibm.com/developerworks/cn/linux/l-assembly/index.html

- AT&T 和 Intel 格式中的源操作数和目标操作数的位置正好相反。在 Intel 汇编格式中，目标操作数在源操作数的左边；而在 AT&T 汇编格式中，目标操作数在源操作数的右边。

  ```
  add eax, 1    ;Intel 风格
  addl $1, %eax    ;AT&T 风格
  ```

  

- 在 AT&T 汇编格式中，寄存器名要加上 '%' 作为前缀；而在 Intel 汇编格式中，寄存器名不需要加前缀。

- 在 AT&T 汇编格式中，用 '$' 前缀表示一个立即操作数；而在 Intel 汇编格式中，立即数的表示不用带任何前缀。

- ......



#### 选择一种风格,选择一个编译器

- 选择 Intel 语法,选择 **Netwide Assembler**（简称 **NASM**）
   > https://zh.wikipedia.org/wiki/Netwide_Assembler
   > https://montcs.bloomu.edu/Information/LowLevel/Assembly/assembly-tutorial.html

#### 64 位的汇编程序

> https://www.cnblogs.com/lazycoding/archive/2012/01/02/2310049.html

- hello-world.asm

    ```
    [bits 64]
        global _start

        section .data
        message db "Hello, World!"

        section .text
    _start:
        mov rax, 1
        mov rdx, 13
        mov rsi, message
        mov rdi, 1
        syscall

        mov rax, 60
        mov rdi, 0
        syscall

    ```

- 编译,连接

    ```
    $ nasm -f elf64 hello-world.asm
    $ ld hello-world.o -o hello-world
    $ ./hello-world
    ```



- 阅读执行文件 hello-world

  ```
  $ readelf -a hello-world
  ```
  
  ```
  ELF Header:
    Magic:   7f 45 4c 46 02 01 01 00 00 00 00 00 00 00 00 00 
    Class:                             ELF64
    Data:                              2's complement, little endian
    Version:                           1 (current)
    OS/ABI:                            UNIX - System V
    ABI Version:                       0
    Type:                              REL (Relocatable file)
    Machine:                           Advanced Micro Devices X86-64
    Version:                           0x1
    Entry point address:               0x0
    Start of program headers:          0 (bytes into file)
    Start of section headers:          64 (bytes into file)
    Flags:                             0x0
    Size of this header:               64 (bytes)
    Size of program headers:           0 (bytes)
    Number of program headers:         0
    Size of section headers:           64 (bytes)
    Number of section headers:         7
    Section header string table index: 3
  
  Section Headers:
    [Nr] Name              Type             Address           Offset
         Size              EntSize          Flags  Link  Info  Align
    [ 0]                   NULL             0000000000000000  00000000
         0000000000000000  0000000000000000           0     0     0
    [ 1] .data             PROGBITS         0000000000000000  00000200
         000000000000000d  0000000000000000  WA       0     0     4
    [ 2] .text             PROGBITS         0000000000000000  00000210
         0000000000000027  0000000000000000  AX       0     0     16
    [ 3] .shstrtab         STRTAB           0000000000000000  00000240
         0000000000000032  0000000000000000           0     0     1
    [ 4] .symtab           SYMTAB           0000000000000000  00000280
         0000000000000090  0000000000000018           5     5     8
    [ 5] .strtab           STRTAB           0000000000000000  00000310
         0000000000000020  0000000000000000           0     0     1
    [ 6] .rela.text        RELA             0000000000000000  00000330
         0000000000000018  0000000000000018           4     2     8
  Key to Flags:
    W (write), A (alloc), X (execute), M (merge), S (strings), I (info),
    L (link order), O (extra OS processing required), G (group), T (TLS),
    C (compressed), x (unknown), o (OS specific), E (exclude),
    l (large), p (processor specific)
  
  There are no section groups in this file.
  
  There are no program headers in this file.
  
  There is no dynamic section in this file.
  
  Relocation section '.rela.text' at offset 0x330 contains 1 entry:
    Offset          Info           Type           Sym. Value    Sym. Name + Addend
  00000000000c  000200000001 R_X86_64_64       0000000000000000 .data + 0
  
  The decoding of unwind sections for machine type Advanced Micro Devices X86-64 is not currently supported.
  
  Symbol table '.symtab' contains 6 entries:
     Num:    Value          Size Type    Bind   Vis      Ndx Name
       0: 0000000000000000     0 NOTYPE  LOCAL  DEFAULT  UND 
       1: 0000000000000000     0 FILE    LOCAL  DEFAULT  ABS hello-world.asm
       2: 0000000000000000     0 SECTION LOCAL  DEFAULT    1 
       3: 0000000000000000     0 SECTION LOCAL  DEFAULT    2 
       4: 0000000000000000     0 NOTYPE  LOCAL  DEFAULT    1 message
       5: 0000000000000000     0 NOTYPE  GLOBAL DEFAULT    2 _start
  
  No version information found in this file.
  
  ```

- 执行文件

  ```
  objdump -d hello-world.o
  ```

  

- 代码分析:

  - ...
  - ...




### 第 5 章 [bx] 和 loop 指令

- [bx] 表示段地址为 ((ds)*16 + (bx)) 的内存单元

- 单元的长度类型由具体指令中的其他操作对象(比如说寄存器)指出

  ```
  mov al,[bx]    ;将 ((ds)*16 + (bx)) 单元的长度为 1 字节(字节单元)内容送入寄存器 al 中
  mov ax,[bx]    ;将 ((ds)*16 + (bx)) 单元的长度为 2 字节(字单元)内容送入寄存器 ax 中
  ```

- bx 可以当作普通寄存器使用,比如赋值,存储等.当它作为 偏移位置的时候 [bx], 其它寄存器都是不可以的

  ```
  mov al,[cx]    ;error,must be index or base register
  ```

  

- loop 循环之意

  ```
  loop
  英 [luːp]   美 [luːp]  
  n.
  环形;环状物;圆圈;(绳、电线等的)环，圈;循环电影胶片;循环音像磁带
  v.
  使成环;使绕成圈;成环形运动
  
  ```

  

### 5.1 [BX]

- 一些细节

  ```assembly
  assume cs:codesg    ;将程序指向 codesg 这个程序段
  
  codesg segment    ;segment 开始
  				  ; codesg 标注这个程序段
  
      ; 共有的规律
      ;mov [bx],0016    ; error,不可以直接给内存单元赋值
      ;mov al,[cx]    ;error,must be index or base register
  
      ; dos debug 中
      ;mov ax,15h    ; error,因为 dos debug 中默认就是 16 进制哦
      
      ; 源程序中
      mov ax,15      ; debug exe 文件之后，转为 mov ax,000F
      mov bx,15h     ; debug exe 文件之后，转为 mov ax,0015
  
  
      mov ax,4c00h
      int 21h
  
  
  codesg ends    ;segment end
  
  end    ; program end
  ```



### 5.2 Loop 指令

- CPU 执行 loop s 的时候，要进行两步操作：

  1. (cx)=(cx)-1;
  2. 判断 cx 中的值，不为 0 则转至标号 s 所标识的地址处执行，如果为零则执行下一条指令

- 可以发现，汇编中的 loop 指令，很类似于其它高级语言中的 do...while() 循环

-  习题之：编程，用加法计算 123*236，结果存在 ax 中

  - 分析：首先得考虑 ax 保存计算结果是否越界 ？8086CPU的 16 位寄存器最大数值是 256*256 -1，所以没有越界

  - 分析： 我们将采用 loop 循环得方式来计算，循环次数决定了效率，所以保存结果 236，循环 123 次，这样效率是比较高的

    ```assembly
    assume cs:codesg    ;将程序指向 codesg 这个程序段
    
    codesg segment    ;segment 开始
    				  ; codesg 标注这个程序段
    
    
        mov ax,0
        mov cx,123
    s:  add ax,256
        loop s
    
        mov ax,4c00h
        int 21h
    
    
    codesg ends    ;segment end
    
    end    ; program end
    ```
    


### 5.3 在 Debug 中跟踪用 loop 指令实现的循环程序

- 计算 ffff:0006 单元中的数乘以 200，结果存储在 dx 中。

  - 分析，最终计算的数据保存在 dx 中会不会越界？ffff:0006 单元中的数据是字节，最多可以乘以 255，所以不会越界

  ```assembly
  assume cs:codesg    ;将程序指向 codesg 这个程序段
  
  codesg segment    ;segment 开始
  				  ; codesg 标注这个程序段
  
  
      mov ax,0ffffh
      mov ds,ax
      mov bx,6
  
      mov ah,0
      mov al,[bx]
  
      mov cx,200
      mov dx,0
  
      add dx,ax
  s:  add dx,ax
      loop s
  
  
      mov ax,4c00h
      int 21h
  
  
  codesg ends    ;segment end
  
  end    ; program end
  ```
  
- debug 分析 CPU 和 内存情况

  - 编译，连接，载入

  ![loop_many_001.jpg](https://i.loli.net/2020/10/07/OpotS2xlmzeTVaN.jpg)

  - 003loop.obj
     ```
        800d 000b 3030 336c 6f6f 702e 6173 6dac
        9609 0000 0643 4f44 4553 47a6 9807 0060
        1b00 0201 01e2 8804 0000 a201 d1a0 1f00
        0100 00b8 ffff 8ed8 bb06 00b4 008a 07b9
        c800 ba00 0003 d0e2 fcb8 004c cd21 408a
        0200 0074 
     ```
     
  - 003loop.exe
     ```
        4d5a 1b00 0200 0000 2000 0000 ffff 0000
        0000 c134 0000 0000 1e00 0000 0100 0000
        0000 0000 0000 0000 0000 0000 0000 0000
        0000 0000 0000 0000 0000 0000 0000 0000
        0000 0000 0000 0000 0000 0000 0000 0000
        0000 0000 0000 0000 0000 0000 0000 0000
        0000 0000 0000 0000 0000 0000 0000 0000
        0000 0000 0000 0000 0000 0000 0000 0000
        0000 0000 0000 0000 0000 0000 0000 0000
        0000 0000 0000 0000 0000 0000 0000 0000
        0000 0000 0000 0000 0000 0000 0000 0000
        0000 0000 0000 0000 0000 0000 0000 0000
        0000 0000 0000 0000 0000 0000 0000 0000
        0000 0000 0000 0000 0000 0000 0000 0000
        0000 0000 0000 0000 0000 0000 0000 0000
        0000 0000 0000 0000 0000 0000 0000 0000
        0000 0000 0000 0000 0000 0000 0000 0000
        0000 0000 0000 0000 0000 0000 0000 0000
        0000 0000 0000 0000 0000 0000 0000 0000
        0000 0000 0000 0000 0000 0000 0000 0000
        0000 0000 0000 0000 0000 0000 0000 0000
        0000 0000 0000 0000 0000 0000 0000 0000
        0000 0000 0000 0000 0000 0000 0000 0000
        0000 0000 0000 0000 0000 0000 0000 0000
        0000 0000 0000 0000 0000 0000 0000 0000
        0000 0000 0000 0000 0000 0000 0000 0000
        0000 0000 0000 0000 0000 0000 0000 0000
        0000 0000 0000 0000 0000 0000 0000 0000
        0000 0000 0000 0000 0000 0000 0000 0000
        0000 0000 0000 0000 0000 0000 0000 0000
        0000 0000 0000 0000 0000 0000 0000 0000
        0000 0000 0000 0000 0000 0000 0000 0000
        b8ff ff8e d8bb 0600 b400 8a07 b9c8 00ba
        0000 03d0 e2fc b800 4ccd 21
     
     ```
     
   - 编译成 01 代码，这里属于编译器的范畴，暂不深究哈
  
   - 这里的源文件比较简单，连接的文件只有这一个，复杂的程序当然有多个，
     了解即可，暂不深究
     
  - Dos 将执行文件载入之后，进入内存。我们 r 指令查看一下寄存器，(ds),(es), (cs),相差着段位--256 Byte
  
    u 指令查看将要执行的命令，loop 指令的位置在 076A:0014,接下来就是 076A:0016

    ok
  
- ![loop_many_002.jpg](https://i.loli.net/2020/10/07/EPnFMijZGX9BQc3.jpg)
  
- 执行，t
  ![loop_many_003.jpg](https://i.loli.net/2020/10/07/bC6AZnXscKPHj1S.jpg)
  
- 执行，t,准备将 cx 赋值 00C8
  
  我们看到 (ax)=0031,说明该内存单元的值是 0031
  
- ![loop_many_004.jpg](https://i.loli.net/2020/10/07/AwKE9rOly4tXDUG.jpg)
  
- 执行，t, 当 loop 执行之后，cx 将会减一 ,观察 CPU 的寄存器是很重点的内容哦~
  
  cx == 200, 将要执行 200 次 t，肯定由快速执行的方法的
  
  1. 当再次执行到 loop 的时候，p 指令即可
  2. 上面有说到 “loop 指令的位置在 076A:0014,接下来就是 076A:0016”，g 0016 即可

  ![loop_many_005.jpg](https://i.loli.net/2020/10/07/vIj8UHznRVbCeta.jpg)
  
- 可以看到最后 (dx) = 2648，到底对不对呢？
  
  ```
  2*16^3 + 6*16^2 + 4*16^1 + 8 = 9800
  0031h = 49    ;以上提及到，内存单元的值是 0031h
  49 * 200 = 9800
  ```
  
- ![loop_many_006.jpg](https://i.loli.net/2020/10/07/9viHeLtPqd1pMZg.jpg)



### 5.4 Debug 汇编编译器 masm 对指令的不同处理