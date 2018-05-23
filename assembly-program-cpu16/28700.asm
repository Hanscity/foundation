assume cs:code

code segment

	a:db 1,2,3,4,5,6,7,8
	b:dw 0

start:
	
	mov si,offset a
	mov bx,offset b
	mov cx,8
	mov ax,0
	s:
	add al,cs:[si]
	inc si
	loop s
	adc ah,0
	mov cs:[bx],ax
	mov ax,4c00h
	int 21h
code ends
end start

