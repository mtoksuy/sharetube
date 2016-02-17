<?php
/*
・過去nヶ月のうちxヶ月間540円、n-xヶ月間525円プレミアム会員費を払っていた
・nとxが与えられるので合計額を出力しなさい。
*/
$n=2;
$x=1;
$m=540;
$p=525;
$answer=($x*$m)+($p*($n-$x));
echo $answer;




/*
・25を繰り返した文字列をニコニコ文字列と呼ぶ
・数学から成る文字列Sにニコニコ文字列となるような部分文字列は何箇所あるか
・例：12512525 -> 4箇所(25となるのが3箇所 2525となるのが1箇所)
*/
$s = '12512525';
$pattern = '/25/';
preg_match_all($pattern, $s,$s_array);
var_dump($s_array);
$pattern = '/2525/';
preg_match_all($pattern, $s,$ss_array);
var_dump($ss_array);

preg__all($pattern, $s,$ss_array);








for($i=0;$i<=10;$i++) {
		echo $i.'<br>';
/*
	for($ii=0;$ii<=10;$ii++) {
	}
*/
}
/*
void solve() {
	int i,j,k,l,r,x,y; string s;
	cin>>S;
	
	x=0;
	FOR(i,S.size()) {
		if((x%2==0 && S[i]=='2') || (x%2==1 && S[i]=='5')) x++;
		else {
			ret+=1LL*(x/2)*(x/2+1)/2;
			x=0;
			if(x%2==0 && S[i]=='2') x++;
		}
	}
	ret+=1LL*(x/2)*(x/2+1)/2;
	cout<<ret<<endl;

*/














?>