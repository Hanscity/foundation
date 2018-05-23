assume cs:code

data segment
	
data ends

code segment
	table dw ag0,ag30,ag60,ag90,ag120,ag150,ag180
	ag0 db '0',0
	ag30 db '0.5',0
	ag60 db '0.866',0
	ag90 db '1',0
	ag120 db '0.866',0
	ag150 db '0.5',0
	ag180 db '0',0
start:
	
	mov ax,60

	call sinshow

	mov ax,4c00h
	int 21h

sinshow:
	push bx
	push es
	push di
	push dx

	mov bx,0b800h
	mov es,bx
	mov di,80*2*6+40*2

	mov bl,30
	div bl
	mov bh,0
	mov bl,al
	add bx,bx
	mov bx,table[bx]

	;---------------------------
sinshowok1:
	mov dl,cs:[bx]
	cmp dl,0
	je sinshowok2
	mov es:[di],dl
	mov byte ptr es:1[di],72H
	inc bx
	add di,2
	jmp short sinshowok1

sinshowok2:
	pop dx
	pop di
	pop es
	pop bx
	ret




code ends
end start

