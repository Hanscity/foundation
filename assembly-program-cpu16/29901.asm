assume cs:code

code segment

setscreen:jmp short set
table dw sub1,sub2,sub3,sub4
set:
	push bx
	cmp ah,3
	ja sret
	mov bl,ah
	add bl,bl
	mov bh,0

	call word ptr table[bx]

sret:
	pop bx
	ret
	

	
start:
	mov al,4
	mov ah,2
	call setscreen

	mov ax,4c00h
	int 21h

sub1:
	push ax
	push es
	push di
	push cx

	mov ax,0b800h
	mov es,ax
	mov di,0
	mov cx,2000
	sub1s:
	mov byte ptr es:[di],' '
	add di,2
	loop sub1s

	pop cx
	pop di
	pop es
	pop ax

	ret

sub2:
	push bx
	push es
	push di
	push cx

	mov bx,0b800h
	mov es,bx
	mov di,1
	mov cx,2000


	sub2s:
	mov ah,es:[di]
	and ah,11110000b
	or ah,al
	mov es:[di],ah
	add di,2
	loop sub2s

	pop cx
	pop di
	pop es
	pop ax

	ret

sub3:
	push bx
	push es
	push di
	push cx

	mov bx,0b800h
	mov es,bx
	mov di,1
	mov cx,2000

	shl al,1
	shl al,1
	shl al,1
	shl al,1

	sub3s:
	mov ah,es:[di]
	and ah,00001111b
	or ah,al
	mov es:[di],ah
	add di,2
	loop sub3s

	pop cx
	pop di
	pop es
	pop ax

	ret
sub4:

	push cx
	push si
	push di
	push es
	push ds

	mov si,0b800h
	mov es,si
	mov ds,si
	mov si,160
	mov di,0
	cld
	mov cx,24

sub4s:
	push cx
	mov cx,160
	rep movsb
	pop cx
	loop sub4s

	sub si,2
	mov cx,80
sub4s1:
	mov byte ptr ds:[si],'c'
	sub si,2
	loop sub4s1

	pop ds
	pop es
	pop di
	pop si
	pop cx

	ret





code ends
end start
