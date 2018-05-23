;==========================================================================

;下面的程序,分别在屏幕的2、4、6、8行显示4句英文诗,补全程序.

;完成后编译运行,体会其中的思想.

;==========================================================================

ASSUME CS:CODE

 

CODE SEGMENT

    ;书上S1、S2、S3、S4、S、ROW后面有冒号":",

    ;然而这样在有的编译器里编译貌似通不过的说

    ;MASM2015的编译器ML.EXE 6.11版不行,MASM.EXE可以

    S1  DB "Good,better,best,",'$'

    S2  DB "Never let itrest,",'$'

    S3 DB "Till good isbetter,",'$'

    S4 DB "Andbetter,best.",'$'

    S   DW OFFSET S1,OFFSET S2,OFFSET S3,OFFSET S4

    ROW DB 2,4,6,8

   

START:

    MOV AX,CS           ;DS和CS使用同一段

    MOV DS,AX

    MOV BX,OFFSET S     ;BX用来寻址字符串的首地址

    MOV SI,OFFSET ROW   ;SI用来寻址行数

    MOV CX,4            ;循环次数4

OK:

    MOV BH,0            ;0页

    MOV DH,BYTE PTR CS:[SI] ;(DH)=行数

    MOV DL,0            ;(DL)=列数

    MOV AH,2            ;置光标

    INT 10H

   

    MOV DX,CS:[BX]  ;DS:DX指向字符串的首地址

    MOV AH,9            ;输出以"$"结尾的字符串

    INT 21H

   

    INC SI              ;SI指向下一句诗的行数

    ADD BX,2            ;BX指向下一句诗的字符串的首地址

    LOOP OK         ;输出下一句诗

   

    MOV AX,4C00H

    INT 21H

CODE ENDS

END START