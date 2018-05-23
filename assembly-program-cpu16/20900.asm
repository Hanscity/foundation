assume cs:code

data segment
	db 16 dup (0)
	db 16 dup (0)
	dw 12666
data ends

stack segment
	db 48 dup (0)
stack ends

code segment
start:
	mov ax,stack
	mov ss,ax
	mov sp,16
	mov ax,data
	mov ds,ax


	mov ax,ds:[32]
	mov dx,0000H
	mov cx,0AH
	mov si,16
	mov di,0

smain:
	push cx
	mov cx,ax
	jcxz enddiv
	pop cx
	call divdw
	mov ds:[si],cx
	mov cx,0AH
	add si,2
	inc di
	jmp smain


enddiv:
	mov al,0
	mov ds:[di],al
	mov cx,di
	mov bx,0
	sub si,2
s2:

	push ds:[si]
	pop ax
	add ax,30H
	mov ds:[bx],ax
	sub si,2
	inc bx
	loop s2



	mov dh,8	;第几行
	mov dl,3	;第几列
	mov cl,02h	;指定颜色
	

	mov si,0
	call show_str	;调用函数显示即可

	mov ax,4c00h
	int 21h

;此程序是显存的调用接口---------------------------------------------------
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



	


;此程序是做除法的溢出，当然包含程序的不溢出-------------------------------------
divdw:
	push di
	push ax
	mov ah,dh
	mov al,dl
	mov dx,0
	div cx
	mov di,ax ;保存高位的商
	pop ax
	div cx
	mov cx,dx
	mov dx,di
	pop di
	ret			;不过，这个子程序就改变了寄存器的值哦。


	



	
code ends
end start