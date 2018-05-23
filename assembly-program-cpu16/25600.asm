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


	;------------------------main program
	mov ax,0b800h
	mov es,ax
	mov di,160*12

	mov bx,offset s - offset se
	mov cx,80
s:
	mov byte ptr es:[di],'!'
	add di,2
	int 7ch
	;loop s
se: nop

	mov ax,4c00h
	int 21h


	;------------------------int program
d0start:
	push bp
	mov bp,sp
	dec cx
	jcxz ok1
	add [bp+2],bx

ok1:
	pop bp
	iret

d0end:nop


code ends
end start