;in 004478F5 
;should be
CMP DWORD PTR SS:[EBP+60],EDI
;replace with
JMP SHORT 004478DB
;should jmp to nop nop nop nop  (or MOV EAX,EAX or whatever useless command)
;replace 004478DB with
JMP LONG 0047DEA9
; should jmp to a bunch of 0x00000000000000000000000000
;replace 0047DEA9 with
0007DEA9   C745 60 82000000 MOV DWORD PTR SS:[EBP+60],82 ; outfit ID 130
0007DEB0   BF 82000000      MOV EDI,82 ; EDI 130 because fuck you
0007DEB5   C645 65 32       MOV BYTE PTR SS:[EBP+65],32 ; first head byte 50
0007DEB9   C645 66 32       MOV BYTE PTR SS:[EBP+66],32 ; second head byte 50
0007DEBD   C645 67 32       MOV BYTE PTR SS:[EBP+67],32 ; third head byte 50
0007DEC1   C645 68 32       MOV BYTE PTR SS:[EBP+68],32 ; first body byte 50
0007DEC5   C645 69 32       MOV BYTE PTR SS:[EBP+69],32 ; second body byte 50
0007DEC9   C645 6A 32       MOV BYTE PTR SS:[EBP+6A],32 ; third body byte 50
0007DECD   C645 6B 32       MOV BYTE PTR SS:[EBP+6B],32 ; first pants byte 50
0007DED1   C645 6C 32       MOV BYTE PTR SS:[EBP+6C],32 ; second pants byte 50
0007DED5   C645 6D 32       MOV BYTE PTR SS:[EBP+6D],32 ; third pants byte 50
0007DED9   C645 6E 32       MOV BYTE PTR SS:[EBP+6E],32 ; first toes byte 50
0007DEDD   C645 6F 32       MOV BYTE PTR SS:[EBP+6F],32 ; second toes byte 50
0007DEE1   C645 70 32       MOV BYTE PTR SS:[EBP+70],32 ; third toes byte 50
0007DEE5  ^E9 0E9AFCFF      JMP 000478F8
