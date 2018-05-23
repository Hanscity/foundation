assume cs:code

data segment
	db 'conversation',0
data ends

code segment
start:

	;---------------------------------程序主体
	mov ax,data
	mov ds,ax
	mov si,0
	int 7ch
	
	;---------------------------------零号中断程序是直接退出了程序，直接返回了DOS
	;---------------------------------所以，这里就不保存寄存器的值了。
	mov ax,4c00h
	int 21h


code ends
end start