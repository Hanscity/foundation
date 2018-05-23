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
start:
	
	


code ends
end start

