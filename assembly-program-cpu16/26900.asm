assume cs:code

code segment
start:
	
	mov al,8
	out 70h,al
	in al,71h

	mov ah,al
	mov cl,4
	shr ah,cl
	and al,00001111b

	add ah,30h
	add al,30h

	mov bx,0b800h
	mov ds,bx
	mov si,80*2*6+30*2
	mov ds:[si],ah
	mov cl,71h
	mov ds:[si+1],cl
	add si,2
	mov ds:[si],al
	mov ds:[si+1],cl

	mov ax,4c00h
	int 21h

code ends
end start