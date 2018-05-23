assume cs:codesg,ds:datasg,ss:stacksg

datasg segment
	db 'welcome to masm!' ;define the str
	db 02h,24h,71h  ; define the color
datasg ends

stacksg segment
	dw 8 dup (0) ;
stacksg ends

codesg segment	

start:	
	mov ax,datasg
	mov ds,ax
	mov ax,0b800h
	mov es,ax
	mov ax,stacksg
	mov ss,ax
	mov sp,16

	mov cx,3
	mov ax,07bch
	mov bp,ax
	mov bx,0
	mov si,0
	mov di,0
	s1:push cx
	push si
	push di



	mov cx,16
	s2:
	mov al,ds:[si]
	mov es:[bp+di],al
	mov al,ds:16[bx]
	mov es:[bp+di+1],al

	inc si
	add di,2
	loop s2


	inc bx
	pop di
	pop si
	pop cx
	add bp,00a0h
	loop s1

	mov ax,4c00h
	int 21h
codesg ends
end start
