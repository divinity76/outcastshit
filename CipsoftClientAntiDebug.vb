'the server uses custom spr/dats, some of them make the cipsoft client debug. fix that..

GetTheMobileInfo:
    outfitType = CLng(packet(resF.pos)) 'HHB INTERESTING 1 ANTIDEBUG
    outfitType = 130
        packet(resF.pos) = 130
        packet(resF.pos + 1) = LowByteOfLong(tileID_Oracle)
        packet(resF.pos + 2) = HighByteOfLong(tileID_Oracle)
    packet(resF.pos + 3) = LowByteOfLong(tileID_Oracle)
    packet(resF.pos + 4) = HighByteOfLong(tileID_Oracle)



LearnFromPacket:
    Case &H8D
      ' Light update
      If (frmHardcoreCheats.chkLight.Value = 1) Then
        ' keep cheat light - NEW since 25.8
        tmpStr = GoodHex(packet(pos + 1)) & GoodHex(packet(pos + 2)) & GoodHex(packet(pos + 3)) & GoodHex(packet(pos + 4))
        If (tmpStr = IDstring(idConnection)) Then
          packet(pos + 5) = CByte("&H" & LightIntesityHex)
          packet(pos + 6) = CByte("&H" & nextLight(idConnection))
        End If
      End If
      pos = pos + 7
      Debug.Print "LearnFromPacket (x3) Outfit: " & outfitType





LearnFromPacket:
      ElseIf TibiaVersionLong <= 760 Then
        outfitType = CLng(packet(pos))
      If (outfitType = 9 Or outfitType = 84) Then  'ANTIDEBUG
      outfitType = 130
      packet(pos) = 130
    packet(pos + 1) = LowByteOfLong(tileID_Oracle)
    packet(pos + 2) = HighByteOfLong(tileID_Oracle)
    packet(pos + 3) = LowByteOfLong(tileID_Oracle)
    packet(pos + 4) = HighByteOfLong(tileID_Oracle)
      End If
      Debug.Print "LearnFromPacket (x4) Outfit: " & outfitType




LearnFromPacket:
      ElseIf TibiaVersionLong <= 760 Then
        outfitType = CLng(packet(pos))
      If (outfitType = 9 Or outfitType = 84) Then  'ANTIDEBUG
      outfitType = 130
      packet(pos) = 130
    packet(pos + 1) = LowByteOfLong(tileID_Oracle)
    packet(pos + 2) = HighByteOfLong(tileID_Oracle)
    packet(pos + 3) = LowByteOfLong(tileID_Oracle)
    packet(pos + 4) = HighByteOfLong(tileID_Oracle)
      End If
      Debug.Print "LearnFromPacket (x4) Outfit: " & outfitType



