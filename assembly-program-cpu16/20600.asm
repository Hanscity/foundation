assume cs:code
data segment
	db 'welcome to masm!',0
data ends

stack segment
	dw 8 dup (0)
stack ends
code segment
start:
	mov ax,stack
	mov ss,ax
	mov sp,16
	mov ax,data
	mov ds,ax

	mov dh,8	;第几行
	mov dl,3	;第几列
	mov cl,71h	;指定颜色

	mov si,0
	call show_str	;调用函数显示即可

	mov ax,4c00h
	int 21h

show_str:
	push ax
	push bx
	push es
	push cx
	push di

	mov al,0a0h
	sub dh,1
	mul dh
	mov bx,ax
	mov al,4
	dec dl
	mul dl
	add bx,ax
	mov ax,0b800h
	mov es,ax
	mov di,0
	;mov al,ss:[6]
	mov al,cl

s1:
	mov ch,0
	mov cl,ds:[si]
	jcxz ok1
	mov es:[bx+di],cl
	mov es:[bx+di+1],al
	inc si
	add di,2
	jmp s1

ok1:
	pop di
	pop cx
	pop es
	pop bx
	pop ax
	ret

	


code ends
end start