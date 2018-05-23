assume cs:code
	
code segment
start:
	
	mov ax,0b800h
	mov es,ax
	mov ah,'a'
ok1:
	cmp ah,'z'
	ja ok2
	mov es:[80*2*12+40*2],ah
	call delay
	inc ah
	jmp short ok1
ok2:
	mov ax,4c00h
	int 21h

delay:
	push ax
	push dx
	mov dx,6h
	mov ax,0
s1:	
	sub ax,1
	sbb dx,0
	cmp ax,0
	jne s1
	cmp dx,0
	jne s1
	pop dx
	pop ax
	ret


code ends
end start