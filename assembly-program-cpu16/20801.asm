assume cs:code

stack segment
	dw 8 dup (0)
stack ends

code segment
start:
	mov ax,stack
	mov ss,ax
	mov sp,16
	mov ax,4240H
	mov dx,000FH
	mov cx,0AH
	call divdw

	mov ax,4c00h
	int 21h


divdw:
	push ax
	mov ah,dh
	mov al,dl
	mov dx,0
	div cx
	mov di,ax ;保存高位的商
	pop ax
	div cx
	mov cx,dx
	mov dx,di
	ret			;不过，这个子程序就改变了寄存器的值哦。


	
code ends
end start