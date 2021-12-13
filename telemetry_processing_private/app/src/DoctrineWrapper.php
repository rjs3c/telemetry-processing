<?php


namespace TelemProc;


class DoctrineWrapper
{


    public function __construct()
    {
    }

    public function __destruct()
    {

    }

    public function storeTelemetryData($queryBuilder, array $cleaned_parameters) : array
    {
        $store_result = [];

        $telemetry_data = $cleaned_parameters[0];

        $sender_group = $telemetry_data['GID'];
        $sender_number = $telemetry_data['MSDN'];
        $temperature = $telemetry_data['TMP'];
        $keypad = $telemetry_data['KP'];

        $switch_data = $telemetry_data['SW'];

        //Must convert to boolean so it can be store as a bit

        $fan = boolval($telemetry_data['FN']);

        $switch_one = boolval($switch_data['SW1']);
        $switch_two = boolval($switch_data['SW2']);
        $switch_three = boolval($switch_data['SW3']);
        $switch_four = boolval($switch_data['SW4']);

        $fan = false;

        $queryBuilder = $queryBuilder->insert('telemetry_data')
            ->values([
                'sender_number' => ':sender_number',
                'sender_group' => ':sender_group',
                'switch_one' => ':switch_one',
                'switch_two' => ':switch_two',
                'switch_three' => ':switch_three',
                'switch_four' => ':switch_four',
                'fan' => ':fan',
                'temperature' => ':temperature',
                'keypad' => ':keypad',

            ])
            ->setParameters([
                'sender_number' => $sender_number,
                'sender_group' => $sender_group,
                'switch_one' => $switch_one,
                'switch_two' => $switch_two,
                'switch_three' => $switch_three,
                'switch_four' => $switch_four,
                'fan' => $fan,
                'temperature' => $temperature,
                'keypad' => $keypad,
            ]);

        //$store_result = array(true);

        $store_result['outcome'] = $queryBuilder->execute();
        echo ($store_result['outcome']);
        $store_result['sql_query'] = $queryBuilder->getSQL();

        return $store_result;
    }

    public function fetchTelemetryData($queryBuilder) : array
    {

        $queryBuilder
            ->select('d.*')
            ->from('telemetry_data', 'd')
            ->orderBy('d.timestamp', 'DESC')
            ->setMaxResults(2);

        //select * from tbl_name order by id desc limit N;

        $query = $queryBuilder->execute();
        $result = $query->fetchAll();
        //$result['outcome'] = $query;

        var_dump($result);

        return $result;
    }

}