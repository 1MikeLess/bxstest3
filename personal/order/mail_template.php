<table border="1">
  <thead>
    <tr>
      <th>Товар</th>
      <th>Цена</th>
      <th>Кол-во</th>
      <th>Итого</th>
    </tr>
  </thead>
  <tbody>
    <? foreach ($arOrderItems as $arItem): ?>
    <tr>
      <td><?=$arItem['NAME']?></td>
      <td><?=$arItem['PRICE']?></td>
      <td><?=$arItem['QTY']?> шт.</td>
      <td><?=$arItem['SUM']?></td>
    </tr>
    <? endforeach; ?>
    <tr>
      <td colspan="3" style="text-align:right">Итого:</td>
      <td><?=$orderTotalFormatted?></td>
    </tr>
  </tbody>
</table>
