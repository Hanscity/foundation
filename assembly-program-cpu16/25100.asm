assume cs:code


code segment
start:
	
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
	mov word ptr es:[0*4],200h
	mov word ptr es:[0*4+2],0

	;
	mov ax,4fffH
	mov bl,1
	div bl

	;---------------------------------零号中断程序是直接退出了程序，直接返回了DOS
	;---------------------------------所以，这里就不保存寄存器的值了。
	mov ax,4c00h
	int 21h


d0start:
	jmp short start1
	db 'overflow!'
start1:
	mov ax,0
	mov ds,ax
	mov si,202h

	mov ax,0b800h
	mov es,ax
	mov di,(12*160+80)

	mov cx,9
s1:
	mov al,ds:[si]
	mov es:[di],al
	inc si
	add di,2
loop s1
	mov ax,4c00H
	int 21H
d0end:nop

	
	
code ends
end start