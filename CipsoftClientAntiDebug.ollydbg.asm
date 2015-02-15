;in 004478F5 
;should be
CMP DWORD PTR SS:[EBP+60],EDI
;replace with
JMP SHORT 004478DB
;should jmp to nop nop nop nop  (or MOV EAX,EAX or whatever useless command)
;replace 004478DB with
JMP LONG 0047DEA3
; should jmp to a bunch of 0x00000000000000000000000000
;replace 0047DEA3 with
0047DEA3   > 837D 60 00     CMP DWORD PTR SS:[EBP+60],0
0047DEA7   . 75 3C          JNZ SHORT Tibia_mc.0047DEE5
0047DEA9   . C745 60 820000>MOV DWORD PTR SS:[EBP+60],82
0047DEB0   . BF 82000000    MOV EDI,82
0047DEB5   . C645 65 32     MOV BYTE PTR SS:[EBP+65],32
0047DEB9   . C645 66 32     MOV BYTE PTR SS:[EBP+66],32
0047DEBD   . C645 67 32     MOV BYTE PTR SS:[EBP+67],32
0047DEC1   . C645 68 32     MOV BYTE PTR SS:[EBP+68],32
0047DEC5   . C645 69 32     MOV BYTE PTR SS:[EBP+69],32
0047DEC9   . C645 6A 32     MOV BYTE PTR SS:[EBP+6A],32
0047DECD   . C645 6B 32     MOV BYTE PTR SS:[EBP+6B],32
0047DED1   . C645 6C 32     MOV BYTE PTR SS:[EBP+6C],32
0047DED5   . C645 6D 32     MOV BYTE PTR SS:[EBP+6D],32
0047DED9   . C645 6E 32     MOV BYTE PTR SS:[EBP+6E],32
0047DEDD   . C645 6F 32     MOV BYTE PTR SS:[EBP+6F],32
0047DEE1   . C645 70 32     MOV BYTE PTR SS:[EBP+70],32
0047DEE5   >^E9 0E9AFCFF    JMP Tibia_mc.004478F8

;at 004348FA
;should be 
MOV EAX,ESI;2 bytes
SHL EAX,5;3 bytes
CDQ ; 1 byte
;replace with
JMP LONG 0047DF10 ; 5 bytes
nop; 1 byte
;at 0047DF10 should be a bunch of 0x0000000000000000
;replace with
MOV EAX,ESI
SHL EAX,5
test EAX,EAX
JNE SHORT eax_is_not_zero
mov EAX,1
:eax_is_not_zero
CDQ
test ECX,ECX
JNE SHORT ecx_is_not_zero
mov ECX,1
:ecx_is_not_zero
JMP LONG 00434900










;in 00459AF3 should find:
00459AF3  |> 3B35 506E5F00  CMP ESI,DWORD PTR DS:[5F6E50]
00459AF9  |. 7F 0C          JG SHORT Tibia_mc.00459B07;ERROR
00459AFB  |. 8B4C24 24      MOV ECX,DWORD PTR SS:[ESP+24]
00459AFF  |. 3B0D 546E5F00  CMP ECX,DWORD PTR DS:[5F6E54]
00459B05  |. 7E 1B          JLE SHORT Tibia_mc.00459B22;NOT ERROR
;replace with:
00459AF3     E9 43440200    JMP Tibia_mc.0047DF3B
00459AF8     90             NOP
00459AF9     90             NOP
00459AFA     90             NOP
00459AFB     90             NOP
00459AFC     90             NOP
00459AFD     90             NOP
00459AFE     90             NOP
00459AFF     90             NOP
00459B00     90             NOP
00459B01     90             NOP
00459B02     90             NOP
00459B03     90             NOP
00459B04     90             NOP
00459B05     90             NOP
00459B06     90             NOP
;at 0047DF3B should be a bunch of 0x0000000000000000000
;replace with
;assertion: ToRect.width<=Rect[STRETCH_SURFACE].right && ToRect.height<=Rect[STRETCH_SURFACE].bottom
;ToRect.width: ESI AND ??? (TODO: FIND THIS)
;Rect[STRETCH_SURFACE].right: DWORD PTR DS:[5F6E50]
;ToRect.height: ECX AND DWORD PTR SS:[ESP+24]
:Rect[STRETCH_SURFACE].bottom: DWORD PTR DS:[5F6E54]
:check_ToRect_width
CMP ESI,DWORD PTR DS:[5F6E50]; ToRect.width <= Rect[STRETCH_SURFACE].right ?
JLE SHORT check_ToRect_height ; jmp if yes
SUB ESI,1 ;TODO: find and subtract from the original location of ToRect.width !..
JMP SHORT check_ToRect_width
:check_ToRect_height
MOV ECX,DWORD PTR SS:[ESP+24] ; update ToRect.height
CMP ECX,DWORD PTR DS:[5F6E54] ; ToRect.height<= Rect[STRETCH_SURFACE].bottom ? 
JLE SHORT ToRect_height_ok ; jmp if yes
SUB DWORD PTR SS:[ESP+24],1
JMP SHORT check_ToRect_height
:ToRect_height_ok
JMP LONG 00459B22;i wonder what 00459B1F is, as it's not dead code (ADD ESP,14), but is seemingly unreachable...
