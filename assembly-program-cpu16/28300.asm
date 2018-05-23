assume cs:code

data segment
	db 128 dup (0)
data ends

stack segment
	db 128 dup (0)
stack ends

code segment
start:
	; ----------------------初始化内存空间，栈
	mov ax,stack
	mov ss,ax
	mov sp,128

	; ----------------------int 9 的位置保存
	mov ax,0
	mov es,ax
	push es:[4*9]
	push es:[4*9+2]
	pop es:[202]
	pop es:[200]

	;----------------------指定 int 9 的新位置
	;STI(Set Interrupt) 中断标志置1指令 使 IF = 1; CLI(Clear Interrupt) 中断标志置0
	cli
	mov word ptr es:[9*4],204h
	mov word ptr es:[9*4+2],0
	sti
	
	;----------------------复制程序到 0:204 处
	mov ax,cs
	mov ds,ax
	mov si,offset int9

	mov ax,0
	mov es,ax
	mov di,204h

	mov cx,offset int9end - offset int9
	cli
	rep movsb

	mov ax,4c00h
	int 21h

;------------------------运行代码
int9:
	push ax
	push es
	push cx
	push di

	pushf
	call dword ptr cs:[200]  ;程序執行至此，已經進入了安裝程序的位置哦

	in al,60h
	cmp al,3bh
	jne int9ok2
	mov ax,0b800h
	mov es,ax
	mov di,1
	mov cx,2000
	s:inc byte ptr es:[di]
	add di,2
	loop s

int9ok2:
	pop di
	pop cx
	pop es
	pop ax
	iret
int9end:nop

code ends
end start