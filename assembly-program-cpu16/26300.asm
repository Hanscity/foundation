ASSUME CS:CODE

 

CODE SEGMENT

    S1  DB "Good,better,best,",'$'

    S2  DB "Never let itrest,",'$'

    S3 DB "Till good isbetter,",'$'

    S4 DB "Andbetter,best.",'$'

    S   DW OFFSET S1,OFFSET S2,OFFSET S3,OFFSET S4

    ;ROW DB 2,4,6,8
    ROW DB 1,3,5,7

   

START:

    MOV AX,CS           ;DS和CS使用同一段

    MOV DS,AX

    MOV BX,OFFSET S     ;BX用来寻址字符串的首地址

    MOV SI,OFFSET ROW   ;SI用来寻址行数

    MOV CX,4            ;循环次数4
ok: mov bh,0
    mov dh,[si]
    mov dl,0
    mov ah,2
    int 10h

    mov dx,[bx]
    mov ah,9
    int 21h
    inc si
    add bx,2

    loop ok

    mov ax,4c00h
    int 21h

code ends
end start