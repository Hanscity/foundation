assume cs:code

data segment
	db 16 dup (0)
data ends

stack segment
	db 16 dup (0)
stack ends

code segment
start:
	; ----------------------初始化内存空间，栈
	mov ax,data
	mov ds,ax
	mov ax,stack
	mov ss,ax
	; ----------------------int 9 的位置保存
	mov ax,0
	mov es,ax
	push es:[4*9]
	push es:[4*9+2]
	pop ds:[2]
	pop ds:[0]

	;----------------------指定 int 9 的新位置
	;STI(Set Interrupt) 中断标志置1指令 使 IF = 1; CLI(Clear Interrupt) 中断标志置0
	cli
	mov word ptr es:[9*4],offset int9
	mov es:[9*4+2],cs
	sti
	
	;----------------------主程序，展示 a ~ z
	mov ax,0b800h
	mov es,ax
	mov ah,'a'
ok1:
	cmp ah,'z'
	ja ok2
	mov es:[80*2*12+40*2],ah
	call delay
	inc ah
	jmp short ok1
ok2:
	mov ax,4c00h
	int 21h



;---------------------延时程序
delay:
	push ax
	push dx
	mov dx,6h
	mov ax,0
s1:	
	sub ax,1
	sbb dx,0
	cmp ax,0
	jne s1
	cmp dx,0
	jne s1
	pop dx
	pop ax
	ret

int9:
	push ax
	push es

	mov ax,0b800h
	mov es,ax

	pushf
	call dword ptr ds:[0]

	in al,60h
	cmp al,1
	jne int9ok2
	inc byte ptr es:[80*2*12+40*2+1]

int9ok2:
	pop es
	pop ax
	iret

code ends
end start