assume cs:code


code segment
start:
	;----------------------------------安装程序
	mov ax,cs
	mov ds,ax
	mov si,offset d0start

	mov ax,0
	mov es,ax
	mov di,200H

	mov cx,offset d0end-offset d0start
	cld
	rep movsb

	;----------------------------------设置中断向量
	mov ax,0
	mov es,ax
	mov word ptr es:[7cH*4],200h
	mov word ptr es:[7cH*4+2],0

	
	;---------------------------------零号中断程序是直接退出了程序，直接返回了DOS
	;---------------------------------所以，这里就不保存寄存器的值了。
	mov ax,4c00h
	int 21h


d0start:
	push cx
change:
	mov ch,0
	mov cl,ds:[si]
	jcxz ok1
	and cl,11011111b
	mov ds:[si],cl
	inc si
	jmp change

ok1:
	pop cx
	iret

d0end:nop

	
code ends
end start