assume cs:code

datasg segment
    db 'word',0
    db 'unix',0
    db 'wind',0
    db 'good',0
datasg ends

stacksg segment
	dw 8 dup (0)
stacksg ends

code segment

start:	
	
	mov ax,datasg
	mov ds,ax
	mov ax,stacksg
	mov ss,ax
	mov sp,16
	mov si,0
	mov cx,4

	s1:
	call sub1
	add si,5
	loop s1

	
  	mov ax,4c00h
  	int 21h

  	sub1:
	push cx
	push si
	s2:
	mov ch,0
	mov cl,ds:[si]
	jcxz ok1
	And byte ptr [si],11011111b
	inc si
	jmp s2
	ok1:
	pop si
	pop cx
	ret


code ends



end start
