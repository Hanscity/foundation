assume cs:code

data segment
	db	"Beginner's All-purpose Symbolic Instruction Code.",0
data ends


stack segment
	dw 8 dup (0)
stack ends

code segment
start:
	mov ax,data
	mov ds,ax
	mov si,0
	call letterc

	
	mov ax,4c00h
	int 21h


letterc:
	push cx


	s1:
	mov ch,0
	mov cl,ds:[si]
	jcxz ok1

	cmp byte ptr ds:[si],61H
	jb ok2
	cmp byte ptr ds:[si],7aH
	ja ok2
	and cl,11011111B
	mov ds:[si],cl

	ok2:
	inc si
	jmp s1

	ok1:
	pop cx
	ret

	
code ends
end start