ASSUME CS:CODE

 

DATA SEGMENT

    DB "Welcome to masm!",0

DATA ENDS

 
CODE SEGMENT

START:

    ;安装7ch中断

    MOV AX,CS

    MOV DS,AX               ;(DS)=CODE段段地址

    MOV SI,OFFSET SHOW_STR ;(SI)=传送原始位置的起始偏移地址

    MOV AX,0

    MOV ES,AX               ;(ES)=0

    MOV DI,200H         ;(DI)=200H,一段不会被使用的空间,用来存放中断处理程序

    MOV CX,OFFSET SHOW_STR_END-OFFSET SHOW_STR ;(CX)=要复制的中断处理程序的长度

    CLD                 ;DF标志位置零,正向传送

    REP MOVSB               ;将CX个字节的内容从DS:SI复制到ES:DI

                            ;(将中断处理程序从CS段复制到0:200H处)

   

    ;设置中断向量表

    MOV AX,0           

    MOV ES,AX           ;(ES)=0

    MOV WORD PTR ES:[4*7CH],200H    ;设置0号中断的偏移地址为200H

    MOV WORD PTR ES:[4*7CH+2],0     ;设置0号中断的段地址为0   

 

    ;输出字符串,测试7ch中断

    MOV AX,DATA

    MOV DS,AX           ;初始化DS

    MOV SI,0            ;SI=0,DS:SI指向字符串

    MOV DH,10           ;行号

    MOV DL,10           ;列号

    MOV CL,2            ;颜色

   

    INT 7CH         ;调用INT 7CH中断

   

    MOV AX,4C00H

    INT 21H


    ;----------------------------------------------------------------------------  

;功能:显示一个用0结尾的字符串

;参数:DS:SI指向字符串的首地址,(DH)=行号,(DL)=列号,(CL)=颜色

;返回:无

    SHOW_STR:

    PUSH SI         ;保护现场

    PUSH DI

    PUSH AX

    PUSH DX

    PUSH CX

    PUSH ES

   

    MOV AX,0B800H

    MOV ES,AX           ;(ES)=显示缓冲区段地址

    MOV AL,0A0H         ;以下计算初始字符的偏移地址

    MUL DH              ;行数×0A0H(160个字节)

    MOV DI,AX           ;转移到DI中

    MOV AL,2            ;显示缓冲区中一个字符占两个字节空间

    MUL DL              ;2×列号

    ADD DI,AX           ;获得初始字符的偏移地址

 

    BEGIN_SHOW:

    MOV AL,[SI]         ;(AL)=[SI]=字符的ASCII码

    CMP AL,0            ;和0比较,是不是结尾符

    JE SHOW_STR_RET ;是,则跳转到SHOW_STR_RET

    MOV ES:[DI],AL      ;不是,则转移到显示缓冲区(显示到屏幕)

    INC SI              ;SI+1,指向下一个字符

    INC DI              ;DI+1,准备写入字符的属性

    MOV ES:[DI],CL      ;写入字符的属性

    INC DI              ;DI+1,指向下一个字符在显示缓冲区(屏幕上)的位置

    JMP BEGIN_SHOW  ;继续输出下一个字符

    SHOW_STR_RET:

    POP ES          ;恢复现场

    POP CX

    POP DX

    POP AX

    POP DI

    POP SI

    IRET            ;中断返回

    SHOW_STR_END:

    NOP 

;----------------------------------------------------------------------------  

   

CODE ENDS

END START