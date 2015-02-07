'make it possible to login with the 7.6 cipsoft client with the modified login protocol of the custom client.
Public Function HHBFilter(ByRef Bytes() As Byte)
Dim count As Integer
count = UBound(Bytes)
Dim buf() As Byte
GetCheatPacket buf, "27 20 0a 02 20 f8 02 20 71 b6 02 20 0f 20 75 73 65 72 6e 61 6d 65 66 6f 6f 6f 6f 6f 6f 0a 20 70 61 73 73 77 6f 72 64 78 78 0d 0a"
If ComparePackets(Bytes, buf) Then
GetCheatPacket Bytes, "c9 20 0a 03 64 f2 ff 07 20 66 75 63 6b 79 6f 75 19 20 78 58 35 38 34 38 4a 67 6a 72 49 45 70 6f 77 6f 4b 46 6b 66 72 69 72 47 4a 1c 20 31 4f 2b 45 56 48 66 68 6b 47 67 45 32 4c 32 34 48 61 69 4c 48 76 73 51 59 43 67 3d f7 02 20 71 b6 02 20 0f 20 75 73 65 72 6e 61 6d 65 6f 6f 6f 6f 6f 6f 6f 0a 20 70 61 73 73 77 6f 72 64 78 78 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 20 0d 0a"
EndIf
GetCheatPacket buf, "04 00 A0 02 00 01"
If ComparePackets(Bytes, buf) Then
GetCheatPacket Bytes, "04 00 A0 02 00 01 03 00 98 03 00 03 00 98 04 00 03 00 98 03 00 03 00 98 04 00 "
End If
Exit Function
