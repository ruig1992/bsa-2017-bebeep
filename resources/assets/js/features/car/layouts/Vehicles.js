import React from 'react';
import { localize } from 'react-localize-redux';

import ContainerWrapper from 'app/layouts/ContainerWrapper';
import PageHeader from 'app/components/PageHeader';
import VehiclesList from '../components/Containers/VehiclesList';

import LangService from 'app/services/LangService';
import * as lang from '../lang/Vehicles.locale.json';

import '../styles/vehicle.scss';

class Vehicles extends React.Component {

    componentWillMount() {
        LangService.addTranslation(lang);
    }

    render() {
        const { translate } = this.props;

        return (
            <ContainerWrapper className="container--min-height-350">
                <PageHeader header={ translate('vehicles_list.header') } />
                <VehiclesList />
            </ContainerWrapper>
        )
    }
}

export default localize(Vehicles, 'locale');
