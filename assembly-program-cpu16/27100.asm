assume cs:code
	data segment
		db 32 dup (0)
	data ends

	stack segment
		db 16 dup (0)
	stack ends
code segment
start:
	
	mov si,80*2*10+30*2
	;--------------年
	mov al,9
	call exchange
	call show
	;------------ 反斜杠
	mov al,5ch
	call show2
	;--------------月
	mov al,8
	call exchange
	call show
	;------------ 反斜杠
	mov al,5ch
	call show2
	;---------------日
	mov al,7
	call exchange
	call show
	;---------------backspace
	mov al,20h
	call show2

	;--------------时
	mov al,4
	call exchange
	call show

	;-----------冒号
	mov al,3ah
	call show2

	;------------分
	mov al,2
	call exchange
	call show

	;-----------冒号
	mov al,3ah
	call show2

	;------------秒
	mov al,0
	call exchange
	call show





	

	mov ax,4c00h
	int 21h

exchange:
	push cx

	out 70h,al
	in al,71h
	mov ah,al
	mov cl,4
	shr ah,cl
	and al,00001111b
	add ah,30h
	add al,30h

	pop cx
	ret

show:
	push bx
	push ds
	push cx

	mov bx,0b800h
	mov ds,bx
	mov ds:[si],ah
	mov cl,71h
	mov ds:[si+1],cl
	add si,2
	mov ds:[si],al
	mov ds:[si+1],cl
	add si,2

	pop cx
	pop ds
	pop bx
	ret

show2:
	push bx
	push ds
	push cx
	mov bx,0b800h
	mov ds,bx
	mov cl,71h
	mov ds:[si],al
	inc si
	mov ds:[si],cl
	inc si

	pop cx
	pop ds
	pop bx
	ret


code ends
end start