assume cs:code

code segment

	table dw b,'b'

start:
	
	
	mov ax,4c00h
	int 21h
code ends
end start

