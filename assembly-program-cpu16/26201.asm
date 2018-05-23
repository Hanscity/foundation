assume cs:code

data segment
	db "Welcome to masm! ",0
data ends
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
	mov dh,10	;line
	mov dl,10	;arrow
	mov cl,2	;color
	mov ax,data
	mov ds,ax
	mov si,0

	int 7ch

	mov ax,4c00h
	int 21h


	;------------------------int program
d0start:
	push es
	push di
	push ax
	push dx
	mov ax,0b800h
	mov es,ax
	mov di,160*10+2*10

sign01:
	cmp byte ptr ds:[si],0
	je ok1
	mov dl,ds:[si]
	mov es:[di],dl
	mov es:[di+1],cl
	inc si
	add di,2
	jmp short sign01

ok1:
	pop dx
	pop ax
	pop di
	pop es
	iret

d0end:nop


code ends
end start