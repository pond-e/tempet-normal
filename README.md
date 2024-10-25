# tempet web側コード
tempetのweb側のコードです。さくらレンタルサーバー上で動作させる想定で作成しました。

環境
- PHP 8.x
- sqlite3

### 機能
- ログイン機能
- ペットの選択
- tempetに赤外線コードを記録させるフェーズ
- Raspberry Piからの室温の受け取り、表示
- エアコンの遠隔停止機能

### 各種参照ファイル
| ファイル名 | 役割 |
| -------- | -------- |
| Raspi_receive.php | Raspiからpostリクエストを受ける, リモコンの記憶完了時にここに{"state": "success"}を送る |
| Raspi_state.txt | Raspiになってほしい状態が記入されている |
| Raspi_bme.php | Raspiからpostリクエストで室温を送信する, {"data": 22.3} |
| Raspi_selected_pet.txt | どのペットのプリセットを使うかを書いてある |
