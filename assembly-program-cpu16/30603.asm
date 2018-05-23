assume cs:code,ds:data,ss:stack

data segment
string	db 128 dup(0)
;top     dw 0
data ends

stack segment stack
	db 128 dup(0)
stack ends

code segment
start:
	mov ax,stack
	mov ss,ax
	mov sp,128

	call init_reg
	call get_string


	mov ax,4c00h
	int 21h

;-------------------------------
init_reg:
	mov bx,0b800h
	mov es,bx

	mov bx,data
	mov ds,bx
	ret

;------------------------------
get_string: 
	mov si,offset string
	mov di,160*10+40*2
	mov bx,0
getString:
	mov ah,0
	int 16h

	cmp al,20h
	jb notChar

	call char_push
	call show_string
	jmp getString

	
	ret

;-----------------
char_push:
	cmp bx,126
	ja charPushRet
	mov ds:[si+bx],al
	inc bx

charPushRet:
	ret


;------------------
show_string:
	push dx
	push ds
	push es
	push si

	mov di,160*10+40*2
showString:
	mov dl,ds:[si]
	cmp dl,0
	je showStringRet
	mov es:[di],dl
	add di,2
	inc si
	jmp showString


showStringRet:
	;mov byte ptr es:[di],0
	pop si
	pop es
	pop ds
	pop dx

	ret


;------------------不是字符串，则只有两种可能性
notChar: 
	cmp ah,0Eh
	je backspace
	cmp ah,1ch
	;je enter
	jmp getString


;------------------
backspace:
	call char_pop
	jmp getString

char_pop:
	cmp bx,0
	je charPopRet
	dec bx
	mov byte ptr ds:[si+bx],0
	sub di,2
	mov byte ptr es:[di],0

charPopRet: 
	ret






code ends

end start