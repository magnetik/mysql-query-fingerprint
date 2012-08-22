<?php
class MysqlQueryFingerprint
{
    /**
     * From : http://code.google.com/p/maatkit/source/browse/trunk/mk-query-digest/mk-query-digest?r=3968#1518
     * With the great help of : http://www.cs.wcupa.edu/~rkline/perl2php/
     * @param type $query
     */
    public static function generate($query)
    {
		//One line comments
		$query = preg_replace('/(?:--|#)[^\'"\r\n]*(?=[\r\n]|\Z)/', '', $query);

		//Multi line comments
		$query = preg_replace('#/\*[^!].*?\*/#sm', '', $query);

        //Quoted strings
        $query = preg_replace("/\\[\"']/", "", $query);

        //Quoted strings
        $query = preg_replace('/".*?"/s', "?", $query);

        //Quoted strings
        $query = preg_replace("/'.*?'/s", "?", $query);

        //Everything which look like a number
        $query = preg_replace("/[0-9+-][0-9a-f.xb+-]*/", "?", $query);

		$query = preg_replace("/[xb.+-]\?/", "?", $query);

        //Delete leading and trealing whitespaces
        $query = trim($query);

		//Collapses whitespaces
		//TODO: wtf ?
		$query = preg_replace("/[ \n\t\r\f]/s", " ", $query);

		//Makes string lowercase
		$query = strtolower($query);

		//Collapses IN and VALUES
		$query = preg_replace('/\b(in|values?)(?:[\s,]*\([\s?,]*\))+/x', "$1(?+)", $query);

		//Collapses UNION
		$query = preg_replace('/\b(select\s.*?)(?:(\sunion(?:\sall)?)\s\1)+/x', '$1', $query);

		//Collapses LIMIT
		$query = preg_replace('/\blimit \?(?:, ?\?| offset \?)?/', 'limit ?', $query);

		return $query;
    }
}
?>
